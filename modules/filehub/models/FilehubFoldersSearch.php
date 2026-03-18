<?php

namespace app\modules\filehub\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\filehub\models\FilehubFolders;

/**
 * FilehubFoldersSearch represents the model behind the search form of `app\modules\filehub\models\FilehubFolders`.
 */
class FilehubFoldersSearch extends FilehubFolders
{
    public int $is_parent_null = 0;

    public function rules()
    {
        return [
            [['id', 'folder_owner_id', 'folder_parent_id', 'created_at', 'is_parent_null'], 'integer'],
            [['folder_title', 'folder_about', 'folder_code', 'status'], 'safe'],
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
        $query = FilehubFolders::find();

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

        if ($this->is_parent_null)
        {
            $query->andWhere(['is', 'folder_parent_id', null]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'folder_owner_id' => $this->folder_owner_id,
            'folder_parent_id' => $this->folder_parent_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'folder_title', $this->folder_title])
            ->andFilterWhere(['like', 'folder_code', $this->folder_code])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
