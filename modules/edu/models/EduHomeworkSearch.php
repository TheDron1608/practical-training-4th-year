<?php

namespace app\modules\edu\models;

use Yii;
use app\modules\core\models\Groups;
use app\modules\core\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edu\models\EduHomework;

/**
 * EduHomeworkSearch represents the model behind the search form of `app\modules\edu\models\EduHomework`.
 */
class EduHomeworkSearch extends EduHomework
{
    public $group;
    public $subject;
    public $teacher;

    public bool $is_my_homework = false;    // ----- Если нужно достать Дз заданное мне.

    public function rules()
    {
        return [
            [['id', 'homework_teacher_id', 'homework_group_id', 'homework_subject_id', 'homework_answer_file_id', 'created_at', 'updated_at'], 'integer'],
            [['group', 'subject', 'teacher'], 'string'],
            [['homework_file_ids', 'homework_title', 'homework_content', 'homework_deadline', 'homework_options', 'status'], 'safe'],
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
        $query = EduHomework::find()
            ->joinWith(['homeworkGroup'])
            ->joinWith(['homeworkSubject'])
            ->joinWith(['homeworkTeacher']);

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

        if ($this->is_my_homework)
        {
            $userId = Yii::$app->user->id;
            $query->leftJoin(['groups_users'], "`groups_users`.`user_id` = '$userId'")
                ->andFilterWhere(["=", "`groups_users`.`user_role`", "user"]);
            
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'homework_teacher_id'   => $this->homework_teacher_id,
            'homework_group_id'     => $this->homework_group_id,
            'homework_subject_id'   => $this->homework_subject_id,
            'homework_deadline'     => $this->homework_deadline,
        ]);

        $query->andFilterWhere(['like', 'homework_title', $this->homework_title])
            ->andFilterWhere(['like', 'homework_content', $this->homework_content])
            ->andFilterWhere(['like', Groups::tableName().'.group_title', $this->group])
            ->andFilterWhere(['like', EduSubjects::tableName().'.subject_title', $this->subject])
            ->andFilterWhere(['like', "CONCAT(`user_f`, ' ', `user_i`, ' ', `user_o`)", $this->teacher])
            ->andFilterWhere(['like', EduHomework::tableName().'.status', $this->status]);

        return $dataProvider;
    }
}