<?php

namespace app\modules\core\models;

use app\modules\edu\models\EduQualifications;
use app\modules\edu\models\EduSpecialisation;
use app\modules\edu\models\EduSubjects;
use app\modules\edu\models\EduSubjectsGroups;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%groups}}".
 *
 * @property int $id
 * @property int $group_author_id Id автора.
 * @property int|null $group_curator_id Id куратора группы.
 * @property int|null $group_specialisation_id Id специализации.
 * @property string $group_title Название группы.
 * @property string|null $group_about О группе.
 * @property string|null $group_options Доп. настройки.
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $groupCurator
 * @property EduQualifications $groupQualification
 * @property GroupsUsers[] $groupsUsers
 */
class Groups extends ActiveRecord
{
    const STATUS_ACTIVE     = 'active';
    const STATUS_DELETED    = 'deleted';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DELETED,
    ];

    const STATUS_TYPE = [
        self::STATUS_ACTIVE     => 'Активен',
        self::STATUS_DELETED    => 'Удален',
    ];

    public static function tableName()
    {
        return '{{%groups}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ]
        ];
    }

    public $group_users;
    public $group_users_file;
    public $group_subjects;

    public function rules()
    {
        return [
            [['group_title'], 'required'],
            [['group_curator_id', 'group_specialisation_id', 'created_at', 'updated_at'], 'integer'],
            [['group_options', 'group_users'], 'safe'],
            [['group_title'], 'string', 'max' => 255],
            [['group_about'], 'string', 'max' => 1500],
            [['group_subjects'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
            ['group_users_file', 'file', 'extensions' => 'jpg, jpeg, gif, png, pdf, docx, doc, csv, xls, xlsx, txt',
                'maxFiles' => 1, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'group_author_id'           => Yii::t('app', 'Автор'),
            'group_curator_id'          => Yii::t('app', 'Куратор'),
            'group_specialisation_id'    => Yii::t('app', 'Специальность'),
            'group_title'               => Yii::t('app', 'Название'),
            'group_about'               => Yii::t('app', 'О группе'),
            'group_users'               => Yii::t('app', 'Студенты'),
            'group_subjects'            => Yii::t('app', 'Предметы'),
            'status'                    => Yii::t('app', 'Статус'),
            'created_at'                => Yii::t('app', 'Дата создания'),
            'updated_at'                => Yii::t('app', 'Дата редактирования'),
        ];
    }

    /**
     * Gets query for [[GroupCurator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroupCurator()
    {
        return $this->hasOne(User::class, ['id' => 'group_curator_id']);
    }

    public function getGroupSpecialisation()
    {
        return $this->hasOne(EduSpecialisation::class, ['id' => 'group_specialisation_id']);
    }

    public static function getAllCurators()
    {
        $query = self::find()
            ->innerJoin('user', '`groups`.`group_curator_id` = `user`.`id`')
            ->select(['user.id', "CONCAT(`user`.`user_f`, ' ', `user`.`user_i`, ' ', `user`.`user_o`) AS `user_fio`"])
            ->distinct()
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'user_fio');
    }

    /**
     * Gets query for [[GroupsUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroupsUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(GroupsUsers::tableName(), ['group_id' => 'id']);
    }

    public function getGroupSubjects()
    {
        return $this->hasMany(EduSubjects::class, ['id' => 'subject_id'])
            ->viaTable(EduSubjectsGroups::tableName(), ['group_id' => 'id']);
    }

    /* ===== Получить список групп. ===== */
    public static function getGroupList(?string $status = self::STATUS_ACTIVE)
    {
        $query = self::find()
            ->select(['id', 'group_title'])
            ->andFilterWhere(['=', 'status', $status])
            ->orderBy('group_title ASC')
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'group_title');
    }

    /* ===== Получить массив пользователей в группе с дефолтными. ===== */
    public function getDefaultUsersInGroup(): array
    {
        $arrGroupUsers = [
            [
                'user_id'   => $this->group_author_id,
                'user_role' => GroupsUsers::ROLE_AUTHOR,
            ],
            [
                'user_id'   => $this->group_curator_id,
                'user_role' => GroupsUsers::ROLE_CURATOR,
            ],
        ];

        if (is_array($this->group_users))
        {
            $arrGroupUsers = array_merge($arrGroupUsers, $this->group_users);
        }

        return $arrGroupUsers;
    }

    /* ===== Создать / Редактировать группу. ===== */
    public function setGroup(array $data, int $userId, bool $isUpdate = false)
    {
        if ($this->load($data))
        {
            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                if (!$isUpdate)
                {
                    $this->group_author_id = $userId;
                }

                if (!$this->save())
                {
                    throw new \Exception('Error No Save');
                }

                $arrGroupUsers = self::getDefaultUsersInGroup();

                if ( !GroupsUsers::addGroupUsers($arrGroupUsers, $this->id, $isUpdate) )
                {
                    throw new \Exception('Error No Add Group Users');
                }

                if (!empty($this->group_subjects))
                {
                    if ( !EduSubjectsGroups::addSubjectsInGroup($this->group_subjects, $this->id) )
                    {
                        throw new \Exception('Error No Add Items');
                    }
                }
            }
            catch (\Throwable $e)
            {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            return true;
        }

        return false;
    }
}
