<?php

namespace app\modules\edu\models;

use app\modules\core\models\User;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%edu_subjects}}".
 *
 * @property int $id
 * @property string $subject_title Название предмета.
 * @property string|null $subject_about О предмете.
 * @property string $status
 *
 * @property EduSubjectsGroups[] $eduSubjectsGroups
 * @property EduQualifications $subjectQualification
 * @property User $subjectTeacher
 */
class EduSubjects extends ActiveRecord
{
    public $temp_qualification_input;
    public $temp_group_input;

    const STATUS_ACTIVE         = 'active';
    const STATUS_DEACTIVATED    = 'deactivated';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DEACTIVATED,
    ];

    public static function tableName()
    {
        return '{{%edu_subjects}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_title'], 'required'],
            [['cycle_id'], 'integer'],
            [['subject_title', 'subject_about'], 'string', 'max' => 255],
            [['temp_qualification_input', 'temp_group_input'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'subject_qualification_id'  => Yii::t('app', 'Квалификация'),
            'subject_title'             => Yii::t('app', 'Название'),
            'subject_about'             => Yii::t('app', 'О предмете'),
            'status'                    => Yii::t('app', 'Статус'),
            'temp_qualification_input'  => Yii::t('app', 'Квалификации'),
            'temp_group_input'          => Yii::t('app', 'Группы'),
            'cycle_id'                  => Yii::t('app', 'Цикл'),
            'subject_qualifications'    => Yii::t('app', 'Квалификация'),
            'subject_groups'            => Yii::t('app', 'Группы')
        ];
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($this->temp_qualification_input))
        {
            SubjectQualification::generateMultipleSubjectQualifications($this->id, $this->temp_qualification_input);
        }

        if (!empty($this->temp_group_input))
        {
            EduSubjectsGroups::generateMultipleSubjectGroups($this->temp_group_input);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        SubjectQualification::deleteMultipleSubjectQualifictions($this->id);

        return parent::beforeDelete();
    }

    #[ArrayShape([self::STATUS_ACTIVE => "string", self::STATUS_DEACTIVATED => "string"])]
    public static function getStatusAll(): array
    {
        return [
            self::STATUS_ACTIVE         => Yii::t('app', 'Активен'),
            self::STATUS_DEACTIVATED    => Yii::t('app', 'Деактивирован'),
        ];
    }

    /**
     * Gets query for [[EduSubjectsGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduSubjectsGroups()
    {
        return $this->hasMany(EduSubjectsGroups::class, ['subject_qualification_id' => 'id'])
            ->viaTable('subject_qualifications', ['subject_id' => 'id']);
    }

    /**
     * Gets query for [[SubjectQualification]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectQualification()
    {
        return $this->hasOne(EduQualifications::class, ['id' => 'subject_qualification_id']);
    }

    /* ===== Получить список предметов. ===== */
    public static function getSubjectsList(?string $status = self::STATUS_ACTIVE): array
    {
        $query = self::find()
            ->select(['id', 'subject_title'])
            ->andFilterWhere(['=', 'status', $status])
            ->orderBy('subject_title ASC')
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'subject_title');
    }

    public function getSubjectQualifications()
    {
        return $this->hasMany(SubjectQualification::class, ['subject_id' => 'id']);
    }

    public function getSubjectGroups()
    {
        return $this->hasMany(EduSubjectsGroups::class, ['subject_id' => 'id']);
    }

    public function getCycle()
    {
        return $this->hasOne(EduCycle::class, ['id' => 'cycle_id']);
    }

    public function getSubjectIsInGroup($group): bool
    {
        return $this->getSubjectGroups()->where(['=',  'group_id', $group->id])->count() > 0; 
    }
}