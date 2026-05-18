<?php

namespace app\modules\core\models;

use app\modules\core\models\helpers\FileHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%groups_users}}".
 *
 * @property int $id
 * @property int $group_id Id группы.
 * @property int $user_id Id пользователя.
 * @property string $user_role
 *
 * @property Groups $group
 * @property User $user
 */
class GroupsUsers extends \yii\db\ActiveRecord
{
    const ROLE_AUTHOR   = 'author';
    const ROLE_MODER    = 'moder';
    const ROLE_USER     = 'user';
    const ROLE_CURATOR  = 'curator';

    const ROLE_ALL = [
        self::ROLE_AUTHOR,
        self::ROLE_MODER,
        self::ROLE_USER,
        self::ROLE_CURATOR,
    ];

    public static function tableName()
    {
        return '{{%groups_users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id', 'user_role'], 'required'],
            [['group_id', 'user_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::class, 'targetAttribute' => ['group_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['user_role', 'in', 'range' => self::ROLE_ALL],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('app', 'ID'),
            'group_id'  => Yii::t('app', 'Группа'),
            'user_id'   => Yii::t('app', 'Пользователь'),
            'user_role' => Yii::t('app', 'Роль'),
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::class, ['id' => 'group_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getUserGroups(?int $userId): array
    {
        if ($userId === null) return [];

        return self::find()
            ->joinWith(['group'])
            ->where([self::tableName().'.user_id' => $userId])
            ->asArray()
            ->all();
    }

    /* ===== Получить ids пользователей в группе. ===== */
    public static function getUsersInGroup(int $groupId, ?array $dropUserIds = null, bool $isIds = false, $role = null)
    {
        if ($isIds)
        {
            $query = self::find()
                ->select('user_id')
                ->where(['group_id' => $groupId]);

            if ($role !== null) 
            {
                $query->andFilterWhere(['=', 'user_role', $role]);
            }

            return $query->column();
        }
        else 
        {
            $query = self::find()
                ->select(['user_id', 'user_role'])
                ->where(['group_id' => $groupId])
                ->andFilterWhere(['NOT IN', 'user_id', $dropUserIds]);

            if ($role !== null) 
            {
                $query->andFilterWhere(['=', 'user_role', $role]);
            }

            return $query->asArray()->all();
        }
    }

    /* ===== Добавить пользователей в группу. ===== */
    public static function addGroupUsers(array $groupUsers, int $groupId, bool $isDeleteUsersInGroup = true)
    {
        if ($isDeleteUsersInGroup)
        {
            self::deleteUsersInGroup($groupId);
        }

        $arrGroupUsers = [];
        foreach ($groupUsers as $groupUser)
        {
            $arrGroupUsers[] = [
                'group_id'  => $groupId,
                'user_id'   => $groupUser['user_id'],
                'user_role' => $groupUser['user_role'],
            ];
        }

        if (!empty($arrGroupUsers))
        {
            if ( Yii::$app->db->createCommand()
                ->batchInsert(self::tableName(), ['group_id', 'user_id', 'user_role'], $arrGroupUsers)
                ->execute() ) {
                return true;
            }
        }

        return false;
    }

    /* ===== Добавить пользователей из файла. ===== */
    public static function addGroupUsersByFile(string $filePatch, string $role = self::ROLE_USER)
    {
        $fileContent = FileHelper::getFileContent($filePatch, ';');
        if ($fileContent)
        {
            $users = [];
            foreach ($fileContent as &$item)
            {
                $fio = StringHelper::explode($item[0], ' ', true);

                if ( !isset($fio[0]) && !isset($fio[1]) && !isset($item[1]) )
                {
                    return false;
                }

                $users[] = [
                    'user_f'        => $fio[0],
                    'user_i'        => $fio[1],
                    'user_o'        => $fio[2] ?? null,
                    'user_email'    => $item[1],
                    'user_password' => $item[2] ?? null,
                ];
            }

            if (!empty($users))
            {
                if (User::createUsers($users, $role))
                {
                    return true;
                }
            }
        }

        return false;
    }

    /* ===== Удалить пользователей из группы. ===== */
    public static function deleteUsersInGroup(int $groupId)
    {
        return self::deleteAll(['group_id' => $groupId]);
    }
}
