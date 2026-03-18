<?php

namespace app\modules\edu\models;

use app\modules\core\models\CoreFiles;
use app\modules\core\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%edu_homework_users}}".
 *
 * @property int $id
 * @property int $homework_id Id дз.
 * @property int $homework_user_id Id того кому задали.
 * @property array|mixed|null $homework_answer_ids
 * @property string|null $homework_answer_comment
 * @property int|null $homework_grade Оценка за дз.
 * @property string|null $homework_teacher_comment Комментирий от того кто задал.
 * @property string status
 *
 * @property EduHomework $homework
 * @property User $homeworkUser
 */
class EduHomeworkUsers extends ActiveRecord
{
    const STATUS_WAITING_FOR_AN_ANSWER      = 'waiting_for_an_answer';      // ----- Учитель \ Преподаватель выложит дз && на него ещё не ответили.
    const STATUS_WAITING_FOR_VERIFICATION   = 'waiting_for_verification';   // ----- Когда ответ на дз поступил, но ещё не проверили.
    const STATUS_CHECKED                    = 'checked';

    const STATUS_ALL = [
        self::STATUS_WAITING_FOR_AN_ANSWER,
        self::STATUS_WAITING_FOR_VERIFICATION,
        self::STATUS_CHECKED,
    ];

    public static function tableName()
    {
        return '{{%edu_homework_users}}';
    }

    public $answer_files;

    public function rules()
    {
        return [
            [['homework_id', 'homework_user_id'], 'required'],
            [['homework_id', 'homework_user_id', 'homework_grade'], 'integer'],
            [['homework_teacher_comment', 'homework_answer_comment'], 'string', 'max' => 2048],
            [['homework_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduHomework::class, 'targetAttribute' => ['homework_id' => 'id']],
            [['homework_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['homework_user_id' => 'id']],
            [['homework_answer_ids'], 'safe'],
            ['answer_files', 'file', 'extensions' => 'jpg, jpeg, gif, png, pdf, docx, doc, csv, xls, xlsx, txt',
                'maxFiles' => 3, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
            ['status', 'default', 'value' => self::STATUS_WAITING_FOR_AN_ANSWER],
            ['status', 'in', 'range' => self::STATUS_ALL],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'homework_id'               => Yii::t('app', 'ДЗ'),
            'homework_user_id'          => Yii::t('app', 'Пользователь'),
            'homework_answer_ids'       => Yii::t('app', 'Ответ (Файлы)'),
            'homework_answer_comment'   => Yii::t('app', 'Комментарий к ответу'),
            'homework_grade'            => Yii::t('app', 'Оценка'),
            'homework_teacher_comment'  => Yii::t('app', 'Комментарий поставщика'),
        ];
    }

    /**
     * Gets query for [[Homework]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomework()
    {
        return $this->hasOne(EduHomework::class, ['id' => 'homework_id']);
    }

    /**
     * Gets query for [[HomeworkUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkUser()
    {
        return $this->hasOne(User::class, ['id' => 'homework_user_id']);
    }

    public static function getStatusType(): array
    {
        return [
            self::STATUS_WAITING_FOR_AN_ANSWER      => Yii::t('app', 'Ждёт ответа!'),
            self::STATUS_WAITING_FOR_VERIFICATION   => Yii::t('app', 'Ждёт проверки!'),
            self::STATUS_CHECKED                    => Yii::t('app', 'Проверено!'),
        ];
    }

    public static function getHomeworkCountByStatus(?int $homeworkId = null, ?int $homeworkUserId = null, ?string $status = self::STATUS_WAITING_FOR_AN_ANSWER)
    {
        return self::find()
            ->andFilterWhere(['=', 'homework_id', $homeworkId])
            ->andFilterWhere(['=', 'homework_user_id', $homeworkUserId])
            ->andFilterWhere(['=', 'status', $status])
            ->count();
    }

    /* ===== Задать дз множеству пользователей. ===== */
    public static function addHomeworkTheWholeGroup(array $homeworkUserIds, int $homeworkId)
    {
        $insert = [];
        foreach ($homeworkUserIds as $homeworkUserId)
        {
            $insert[] = [
                'homework_id'               => $homeworkId,
                'homework_user_id'          => $homeworkUserId,
                'homework_answer_ids'       => null,
                'homework_answer_comment'   => null,
                'homework_grade'            => null,
                'homework_teacher_comment'  => null,
                'status'                    => self::STATUS_WAITING_FOR_AN_ANSWER
            ];
        }

        if (!empty($insert))
        {
            return Yii::$app->db->createCommand()
                ->batchInsert(self::tableName(), [
                    'homework_id',
                    'homework_user_id',
                    'homework_answer_ids',
                    'homework_answer_comment',
                    'homework_grade',
                    'homework_teacher_comment',
                    'status',
                ], $insert)
                ->execute();
        }

        return false;
    }

    /* ===== Создать / Редактировать запись. ===== */
    public function setHomeworkUser(string $status = self::STATUS_WAITING_FOR_VERIFICATION)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            if ( $this->answer_files = UploadedFile::getInstances($this, 'answer_files') )
            {
                if (!empty($this->homework_answer_ids))
                {
                    CoreFiles::deleteFiles($this->homework_answer_ids);
                    $this->homework_answer_ids = null;
                }

                if ( !$fileIds = CoreFiles::multipleUploadFiles($this->answer_files, $this->homework_user_id) )
                {
                    throw new \Exception('Error No Uploaded');
                }

                $this->homework_answer_ids = $fileIds;
            }

            $this->status = $status;
            if (!$this->save())
            {
                throw new \Exception('Error No Save');
            }
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /* ===== Удалить ответы студента. ===== */
    public function dropHomeworkUser()
    {
        try
        {
            if (!empty($this->homework_answer_ids))
            {
                CoreFiles::deleteFiles($this->homework_answer_ids);
                $this->homework_answer_ids = null;
            }

            $this->homework_answer_comment = null;
            $this->status = self::STATUS_WAITING_FOR_AN_ANSWER;
            return $this->save();
        }
        catch (\Throwable $e)
        {
            return false;
        }
    }
}