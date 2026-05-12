<?php

namespace app\modules\edu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edu\models\EduHomeworkUsers;

/**
 * EduHomeworkUsersSearch represents the model behind the search form of `app\modules\edu\models\EduHomeworkUsers`.
 */
class EduHomeworkUsersSearch extends EduHomeworkUsers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'homework_id', 'homework_user_id', 'homework_grade'], 'integer'],
            [['homework_answer_ids', 'homework_answer_comment', 'homework_teacher_comment'], 'safe'],
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
        $query = EduHomeworkUsers::find();
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
            'homework_id' => $this->homework_id,
            'homework_user_id' => $this->homework_user_id,
            'homework_grade' => $this->homework_grade,
        ]);

        $query->andFilterWhere(['like', 'homework_answer_comment', $this->homework_answer_comment])
            ->andFilterWhere(['like', 'homework_teacher_comment', $this->homework_teacher_comment]);

        return $dataProvider;
    }
}