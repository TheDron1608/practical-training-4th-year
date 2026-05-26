<?php

namespace app\modules\edu\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * EduSubjectsSearch represents the model behind the search form of `app\modules\edu\models\EduSubjects`.
 */
class SubjectQualification extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%subject_qualifications}}';
    }

    public function rules()
    {
        return [
            [['id', 'subject_id', 'qualification_id', 'hours'], 'integer'],
            [['code'], 'string']
        ];
    }

    public static function getSubjectQualificationsList($subjectId)
    {
        $query = self::find()
            ->select(['id', 'code'])
            ->where(['=', 'subject_id', $subjectId])
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'code');
    }

    public static function generateMultipleSubjectQualifications($subjectId, $qualificationDatas)
    {
        //delete old relations
        self::deleteMultipleSubjectQualifictions($subjectId);
        
        //create new relations
        foreach ($qualificationDatas as $qualificationData)
        {
            $newRelation = new SubjectQualification();
            $newRelation->subject_id = $subjectId;
            $newRelation->qualification_id = $qualificationData['qualification_id'];
            $newRelation->code = $qualificationData['code'];
            $newRelation->hours = $qualificationData['hours'];
            $newRelation->save();
        }
    }

    public static function deleteMultipleSubjectQualifictions($subjectId)
    {
        self::deleteAll(['=', 'subject_id', $subjectId]);
    }

    public function getSubject()
    {
        return $this->hasOne(EduSubjects::class, ['id' => 'subject_id']);
    }

    public function getQualification()
    {
        return $this->hasOne(EduQualifications::class, ['id' => 'qualification_id']);
    }
}