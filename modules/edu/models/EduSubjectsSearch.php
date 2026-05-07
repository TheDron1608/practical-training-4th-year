<?php

namespace app\modules\edu\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edu\models\EduSubjects;

/**
 * EduSubjectsSearch represents the model behind the search form of `app\modules\edu\models\EduSubjects`.
 */
class EduSubjectsSearch extends EduSubjects
{
    public $subject_qualification_id;
    public $subject_group_id;
    public $subject_teacher_id;
    public $my_subjects_only = false;
    public $group_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subject_teacher_id', 'subject_qualification_id', 'cycle_id', 'group_id'], 'integer'],
            [['subject_title', 'subject_about', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EduSubjects::find()
            ->leftJoin('edu_subjects_groups', '`edu_subjects`.`id` = `edu_subjects_groups`.`subject_id`')
            ->leftJoin('subject_qualifications', '`edu_subjects`.`id` = `subject_qualifications`.`subject_id`')
            ->leftJoin('edu_qualifications', '`edu_qualifications`.`id` = `subject_qualifications`.`qualification_id`');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['=', '`edu_subjects_groups`.`teacher_id`', $this->my_subjects_only ? Yii::$app->user->id : $this->subject_teacher_id])
            ->andFilterWhere(['=', '`edu_subjects_groups`.`group_id`', $this->group_id])
            ->andFilterWhere(['=', '`edu_qualifications`.`id`', $this->subject_qualification_id])
            ->andFilterWhere(['cycle_id'  => $this->cycle_id]);

        $query->andFilterWhere(['like', 'subject_title', $this->subject_title])
            ->andFilterWhere(['like', 'subject_about', $this->subject_about])
            ->andFilterWhere(['like', EduSubjects::tableName().'.status', $this->status]);

        return $dataProvider;
    }
}
