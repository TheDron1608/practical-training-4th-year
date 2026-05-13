<?php

namespace app\modules\edu\models;

use app\modules\core\models\CoreFiles;
use app\modules\core\models\Groups;
use app\modules\core\models\GroupsUsers;
use app\modules\core\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%edu_homework}}".
 *
 * @property int $id
 * @property int $homework_teacher_id Id учителя который задал дз.
 * @property int $homework_group_id Id группы в которой задали это дз.
 * @property int $homework_subject_id Id предмета по которому задали дз.
 * @property int|null $homework_answer_file_id Id файл с ответом на дз.
 * @property string|null $homework_file_ids Ids прикрепленных файлов.
 * @property string $homework_title
 * @property string|null $homework_content Содержание/Комментарий.
 * @property string|null $homework_deadline К какому времени нужно сдать дз.
 * @property string|null $homework_options Доп. настройки к дз.
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CoreFiles $homeworkAnswerFile
 * @property Groups $homeworkGroup
 * @property EduSubjects $homeworkSubject
 * @property User $homeworkTeacher
 */
class EduHomework extends ActiveRecord
{
    const STATUS_ACTIVE         = 'active';
    const STATUS_DEACTIVATED    = 'deactivated';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DEACTIVATED,
    ];

    public static function tableName()
    {
        return '{{%edu_homework}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ]
        ];
    }

    public $homework_files;

    public function rules()
    {
        return [
            [['homework_teacher_id', 'homework_subject_id', 'homework_title'], 'required'],
            [['homework_teacher_id', 'homework_group_id', 'homework_subject_id', 'homework_answer_file_id', 'created_at', 'updated_at'], 'integer'],
            [['homework_file_ids', 'homework_deadline', 'homework_options'], 'safe'],
            [['homework_title'], 'string', 'max' => 512],
            [['homework_content'], 'string', 'max' => 8192],
            [['homework_answer_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreFiles::class, 'targetAttribute' => ['homework_answer_file_id' => 'id']],
            [['homework_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::class, 'targetAttribute' => ['homework_group_id' => 'id']],
            [['homework_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduSubjects::class, 'targetAttribute' => ['homework_subject_id' => 'id']],
            [['homework_teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['homework_teacher_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
            ['homework_files', 'file', 'extensions' => 'jpg, jpeg, gif, png, pdf, docx, doc, csv, xls, xlsx, txt',
                'maxFiles' => 5, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'homework_teacher_id'       => Yii::t('app', 'Учитель'),
            'homework_group_id'         => Yii::t('app', 'Группы'),
            'homework_subject_id'       => Yii::t('app', 'Предметы'),
            'homework_answer_file_id'   => Yii::t('app', 'Файлы'),
            'homework_file_ids'         => Yii::t('app', 'ДЗ (Файлы)'),
            'homework_title'            => Yii::t('app', 'Название'),
            'homework_content'          => Yii::t('app', 'Содержание'),
            'homework_deadline'         => Yii::t('app', 'Сроки'),
            'homework_options'          => Yii::t('app', 'Настройки'),
            'status'                    => Yii::t('app', 'Статус'),
            'created_at'                => Yii::t('app', 'Дата создания'),
            'updated_at'                => Yii::t('app', 'Дата редактирвания'),
            'teacher'                   => Yii::t('app', 'Учитель'),
            'group'                     => Yii::t('app', 'Группы'),
            'subject'                   => Yii::t('app', 'Предметы'),
        ];
    }

    /**
     * Gets query for [[HomeworkAnswerFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkAnswerFile()
    {
        return $this->hasOne(CoreFiles::class, ['id' => 'homework_answer_file_id']);
    }

    /**
     * Gets query for [[HomeworkGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkGroup()
    {
        return $this->hasOne(Groups::class, ['id' => 'homework_group_id']);
    }

    /**
     * Gets query for [[HomeworkSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkSubject()
    {
        return $this->hasOne(EduSubjects::class, ['id' => 'homework_subject_id']);
    }

    /**
     * Gets query for [[HomeworkTeacher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkTeacher()
    {
        return $this->hasOne(User::class, ['id' => 'homework_teacher_id']);
    }

    public function getHomeworkUsers()
    {
        return $this->hasMany(EduHomeworkUsers::class, ['homework_id' => 'id']);
    }

    public static function getStatusType(): array
    {
        return [
            self::STATUS_ACTIVE         => Yii::t('app', 'Активен'),
            self::STATUS_DEACTIVATED    => Yii::t('app', 'Деактивирован'),
        ];
    }

    public function getHomeworkFiles(): array
    {
        if (!empty($this->homework_file_ids))
        {
            return CoreFiles::find()
                ->select([
                    'file_title',
                    'file_patch',
                    'file_size',
                ])
                ->where(['IN', 'id', $this->homework_file_ids])
                ->asArray()
                ->all();
        }

        return [];
    }

    /* ===== Создать / Редактировать дз. ===== */
    public function setEduHomework(array $data, int $userId, bool $isUpdate = false, string $formName = 'EduHomework')
    {
        if ($this->load($data, $formName))
        {
            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                if ( $this->homework_files = UploadedFile::getInstances($this, 'homework_files') )
                {
                    if (!empty($this->homework_file_ids))
                    {
                        CoreFiles::deleteFiles([$this->homework_file_ids]);
                        $this->homework_file_ids = null;
                    }

                    if ( !$fileIds = CoreFiles::multipleUploadFiles($this->homework_files, $userId) )
                    {
                        throw new \Exception('Error No Uploaded Files');
                    }

                    $this->homework_file_ids = $fileIds;
                }

                if (!$isUpdate)
                {
                    $this->homework_teacher_id = $userId;
                }

                $userIds = GroupsUsers::getUsersInGroup($this->homework_group_id, null, true);

                if (empty($userIds))
                {
                    throw new \Exception('Error Empty Array');
                }

                if (!$this->save())
                {
                    throw new \Exception('Error No Save');
                }

                // ----- Задать дз некому множеству.
                if ( !EduHomeworkUsers::addHomeworkTheWholeGroup($userIds, $this->id) )
                {
                    throw new \Exception('Error');
                }
            }
            catch (\Throwable $e)
            {
                //Yii::$app->session->setFlash('error', $e->getMessage());
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            return true;
        }

        return false;
    }

    /* ===== Проверка: Этот ли пользователь является преподвателем, который выложил дз? ===== */
    public function isHomeworkTeacher(int $userId): bool
    {
        return $this->homework_teacher_id === $userId;
    }

    public function getAnswer()
    {
        return $this->hasOne(EduHomeworkUsers::class, ['id' => 'homework_id'])
            ->andOnCondition(['homework_user_id' => Yii::$app->user->id]);
    }

    public function getIsOverdued(): bool
    {
        return $this->homework_deadline <= date("Y-m-d");
    }
}
