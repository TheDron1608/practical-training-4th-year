<?php

namespace app\modules\edu\models;

use app\modules\core\models\Groups;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%edu_subjects_groups}}".
 *
 * @property int $id
 * @property int $subject_id
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
            [['subject_id', 'group_id'], 'required'],
            [['subject_id', 'group_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::class, 'targetAttribute' => ['group_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduSubjects::class, 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'subject_id'    => Yii::t('app', 'Subject ID'),
            'group_id'      => Yii::t('app', 'Group ID'),
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
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(EduSubjects::class, ['id' => 'subject_id']);
    }

    /* ===== Получить ids предметов прикрепленных к группе. ===== */
    public static function getGroupSubjectIds(int $groupId): array
    {
        return self::find()
            ->select('subject_id')
            ->where(['group_id' => $groupId])
            ->column();
    }

    /* ===== Множественное прикреплении предметов к группе. ===== */
    public static function addSubjectsInGroup(array $subjectIds, int $groupId): int
    {
        self::deleteSubjectsInGroup($groupId);

        $insert = [];
        foreach ($subjectIds as $subjectId)
        {
            $insert[] = [
                'subject_id'    => $subjectId,
                'group_id'      => $groupId,
            ];
        }

        return Yii::$app->db->createCommand()
            ->batchInsert(self::tableName(), ['subject_id', 'group_id'], $insert)
            ->execute();
    }

    /* ===== Открепить предметы от группы. ===== */
    public static function deleteSubjectsInGroup(int $groupId)
    {
        return self::deleteAll(['group_id' => $groupId]);
    }
}
