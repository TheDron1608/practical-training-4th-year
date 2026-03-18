<?php

namespace app\modules\core\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\core\models\User;

/**
 * UserSearch represents the model behind the search form of `app\modules\core\models\User`.
 */
class UserSearch extends User
{
    public $user_fio;
    public $student_group;

    public function rules()
    {
        return [
            [['id', 'avatar_id', 'status', 'created_at', 'updated_at', 'last_visit_at'], 'integer'],
            [['user_fio', 'user_f', 'user_i', 'user_o', 'email', 'access_token', 'auth_key', 'password_hash', 'password_reset_token', 'about', 'options', 'role', 'snils', 'student_group'], 'safe'],
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
        $query = User::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'last_visit_at' => $this->last_visit_at,
        ]);

        $query->andFilterWhere(['like', 'user_f', $this->user_f])
            ->andFilterWhere(['like', 'user_i', $this->user_i])
            ->andFilterWhere(['like', 'user_o', $this->user_o])
            ->andFilterWhere(['like', "CONCAT(`user_f`, ' ', `user_i`, ' ', `user_o`)", $this->user_fio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'snils', $this->snils]);

        if (isset($this->role)) {
            $query->innerJoin('auth_assignment', '`user`.`id` = `auth_assignment`.`user_id`')
            ->andWhere(['like', 'auth_assignment.item_name', $this->role]);
        }
        if (isset($this->student_group) && $this->student_group != "") {
            $query->leftJoin('groups_users', '`user`.`id` = `groups_users`.`user_id`')
            ->andWhere(['=', '`groups_users`.`user_role`', GroupsUsers::ROLE_USER])
            ->leftJoin('groups', '`groups_users`.`group_id` = `groups`.`id`')
            ->andWhere(['=', '`groups`.`group_title`', $this->student_group]);
        }

        return $dataProvider;
    }
}
