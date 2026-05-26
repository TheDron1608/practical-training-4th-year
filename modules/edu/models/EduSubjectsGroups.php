<?php

namespace app\modules\edu\models;

use app\modules\core\models\Groups;
use Yii;
use app\modules\core\models\User;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%edu_subjects_groups}}".
 *
 * @property int $id
 * @property int $subject_qualification_id
 * @property int $group_id
 *
 * @property Groups $group
 * @property EduSubjects $subject
 */
class EduSubjectsGroups extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%edu_subjects_groups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_qualification_id', 'group_id', 'teacher_id'], 'required'],
            [['subject_qualification_id', 'group_id', 'teacher_id'], 'integer'],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['teacher_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::class, 'targetAttribute' => ['group_id' => 'id']],
            [['subject_qualification_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubjectQualification::class, 'targetAttribute' => ['subject_qualification_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'subject_qualification_id'    => Yii::t('app', 'Subject ID'),
            'group_id'      => Yii::t('app', 'Group ID'),
        ];
    }

    public static function generateMultipleSubjectGroups($subjectDatas)
    {
        //delete old relations
        self::deleteMultipleSubjectGroups(ArrayHelper::getColumn($subjectDatas, 'subject_qualification_id'));
        
        //create new relations
        foreach ($subjectDatas as $subjectData)
        {
            $newRelation = new EduSubjectsGroups();
            $newRelation->group_id = $subjectData['group_id'];
            $newRelation->subject_qualification_id = $subjectData['subject_qualification_id'];
            $newRelation->teacher_id = $subjectData['teacher_id'];
            $newRelation->save();
        }
    }

    public static function deleteMultipleSubjectGroups($subjectQualificationIds)
    {
        self::deleteAll(['IN', 'subject_qualification_id', $subjectQualificationIds]);
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
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(EduSubjects::class, ['id' => 'subject_qualification_id']);
    }

    public function getTeacher()
    {
        return $this->hasOne(User::class, ['id' => 'teacher_id']);
    }

    /* ===== Получить ids предметов прикрепленных к группе. ===== */
    public static function getGroupSubjectIds(int $groupId): array
    {
        return self::find()
            ->select('subject_qualification_id')
            ->where(['group_id' => $groupId])
            ->column();
    }

    /* ===== Множественное прикреплении предметов к группе. ===== */
    public static function addSubjectsInGroup(array $subjectIds, int $groupId, $teacherId): int
    {
        self::deleteSubjectsInGroup($groupId);

        $insert = [];
        foreach ($subjectIds as $subjectId)
        {
            $insert[] = [
                'subject_qualification_id'    => $subjectId,
                'group_id'      => $groupId,
                'teacher_id'    => $teacherId
            ];
        }

        return Yii::$app->db->createCommand()
            ->batchInsert(self::tableName(), ['subject_qualification_id', 'group_id', 'teacher_id'], $insert)
            ->execute();
    }

    /* ===== Открепить предметы от группы. ===== */
    public static function deleteSubjectsInGroup(int $groupId)
    {
        return self::deleteAll(['group_id' => $groupId]);
    }
}
