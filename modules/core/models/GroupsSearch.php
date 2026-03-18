<?php

namespace app\modules\core\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\core\models\Groups;
use yii\db\ActiveQuery;

/**
 * GroupsSearch represents the model behind the search form of `app\modules\core\models\Groups`.
 */
class GroupsSearch extends Groups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_author_id', 'group_curator_id', 'created_at', 'updated_at', 'group_specialisation_id'], 'integer'],
            [['group_title', 'group_about', 'group_options', 'status'], 'safe'],
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
        $query = Groups::find();

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
            'group_author_id' => $this->group_author_id,
            'group_curator_id' => $this->group_curator_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'group_title', $this->group_title])
            ->andFilterWhere(['like', 'group_about', $this->group_about])
            ->andFilterWhere(['like', 'group_options', $this->group_options])
            ->andFilterWhere(['like', 'status', $this->status]);

        $this->ExtraSearchFilters($query);

        return $dataProvider;
    }

    protected function ExtraSearchFilters(ActiveQuery $query) {}
}
