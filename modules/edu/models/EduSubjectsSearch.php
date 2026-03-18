<?php

namespace app\modules\edu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edu\models\EduSubjects;

/**
 * EduSubjectsSearch represents the model behind the search form of `app\modules\edu\models\EduSubjects`.
 */
class EduSubjectsSearch extends EduSubjects
{
    public $subject_qualification_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subject_teacher_id', 'subject_qualification_id'], 'integer'],
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
            ->joinWith(['subjectTeacher']);

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
        $query->andFilterWhere([
            'subject_teacher_id' => $this->subject_teacher_id
        ]);

        $query->andFilterWhere(['like', 'subject_title', $this->subject_title])
            ->andFilterWhere(['like', 'subject_about', $this->subject_about])
            ->andFilterWhere(['like', EduSubjects::tableName().'.status', $this->status]);

        return $dataProvider;
    }
}
