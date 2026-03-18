<?php

namespace app\modules\core\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\core\models\CoreFiles;

/**
 * CoreFilesSearch represents the model behind the search form of `app\modules\core\models\CoreFiles`.
 */
class CoreFilesSearch extends CoreFiles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_user_id', 'file_size', 'created_at'], 'integer'],
            [['file_title', 'file_patch', 'file_hash', 'file_comment', 'file_extension', 'file_code', 'status'], 'safe'],
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
        $query = CoreFiles::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'         => $query,
            'pagination'    => [
                'pageSize'  => 50,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'file_user_id' => $this->file_user_id,
            'file_folder_id' => $this->file_folder_id,
            'file_size' => $this->file_size,
            'file_code' => $this->file_code,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'file_title', $this->file_title])
            ->andFilterWhere(['like', 'file_patch', $this->file_patch])
            ->andFilterWhere(['like', 'file_hash', $this->file_hash])
            ->andFilterWhere(['like', 'file_extension', $this->file_extension])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}