<?php

namespace app\modules\edu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edu\models\EduQualifications;

/**
 * EduQualificationsSearch represents the model behind the search form of `app\modules\edu\models\EduQualifications`.
 */
class EduQualificationsSearch extends EduQualifications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['status', 'base_education', 'specialisation_id', 'year'], 'safe'],
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
        $query = EduQualifications::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'base_education', $this->base_education])
            ->andFilterWhere(['like', 'specialisation_id', $this->specialisation_id]);

        return $dataProvider;
    }
}
