<?php

namespace app\modules\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%core_files}}".
 *
 * @property int $id
 * @property int $file_user_id Кто создал.
 * @property int|null file_folder_id
 * @property string $file_title Имя файла.
 * @property string $file_patch Путь к файлу.
 * @property string $file_hash Зашифрованный путь к файлу.
 * @property string|null $file_comment Комментарий к файлу.
 * @property string $file_extension Расширение файла.
 * @property int $file_size Размер файла.
 * @property string $file_code Код файла (Пример: Аватар).
 * @property string $status
 * @property int $created_at
 */
class CoreFiles extends ActiveRecord
{
    /* ===== Начало: Статус. ===== */
    const STATUS_ACTIVE     = 'active';
    const STATUS_DELETED    = 'deleted';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DELETED,
    ];
    /* ===== Конец: Статус. ===== */

    /* ===== Начало: КОД файла. ===== */
    const CODE_AVATAR       = 'avatar';
    const CODE_EDU          = 'edu';
    const CODE_FILEHUB      = 'filehub';
    const CODE_FILEHUB_MY   = 'filehub_my';

    const CODE_ALL = [
        self::CODE_AVATAR,
        self::CODE_EDU,
        self::CODE_FILEHUB,
        self::CODE_FILEHUB_MY,
    ];
    /* ===== Конец: КОД файла. ===== */

    const DIR_UPLOADED_FILES    = 'uploaded_files';
    const DIR_TEMP_FILES        = 'temp_files';         // ----- Папка с временными файлами.

    public static function tableName()
    {
        return '{{%core_files}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => time(),
            ]
        ];
    }

    public $file;
    public $upload_files;

    public function rules()
    {
        return [
            [['file_user_id', 'file_title', 'file_patch', 'file_hash', 'file_extension', 'file_size', 'file_code'], 'required'],
            [['file_user_id', 'file_folder_id', 'file_size', 'created_at'], 'integer'],
            [['file_title', 'file_patch', 'file_hash'], 'string', 'max' => 255],
            [['file_comment'], 'string', 'max' => 512],
            [['file_extension'], 'string', 'max' => 10],
            ['file_code', 'in', 'range' => self::CODE_ALL],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
            ['file', 'file', 'extensions' => 'jpg, jpeg, gif, png, pdf, docx, doc, csv, xls, xlsx, txt',
                'maxFiles' => 1, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
            ['upload_files', 'file', 'extensions' => 'jpg, jpeg, gif, png, pdf, docx, doc, csv, xls, xlsx, txt',
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
            'id'                => Yii::t('app', 'ID'),
            'file_user_id'      => Yii::t('app', 'Пользователь'),
            'file_title'        => Yii::t('app', 'Название'),
            'file_patch'        => Yii::t('app', 'Путь'),
            'file_hash'         => Yii::t('app', 'File Hash'),
            'file_comment'      => Yii::t('app', 'Комментарий'),
            'file_extension'    => Yii::t('app', 'Настройки'),
            'file_size'         => Yii::t('app', 'Размер'),
            'file_code'         => Yii::t('app', 'Код'),
            'status'            => Yii::t('app', 'Статус'),
            'created_at'        => Yii::t('app', 'Дата создания'),
        ];
    }

    /* ===== Получить файлы. ===== */
    public static function getFiles(array $fileIds): array
    {
        return self::find()
            ->select([
                'id',
                'file_title',
                'file_patch',
                'file_comment',
                'file_size',
            ])
            ->where(['in', 'id', $fileIds])
            ->asArray()
            ->all();
    }

    public static function getFile(int $fileId): array
    {
        return self::find()
            ->select([
                'id',
                'file_title',
                'file_patch',
                'file_comment',
                'file_size',
            ])
            ->where(['=', 'id', $fileId])
            ->asArray()
            ->one();
    }


    /* ===== Множественная загрузка файлов. ===== */
    public static function multipleUploadFiles(array $files, ?int $userId = null, string $dir = self::DIR_UPLOADED_FILES, string $code = self::CODE_EDU, ?string $comment = null, ?int $folderId = null): array
    {
        if (!isset($userId))
        {
            $userId = Yii::$app->user->id;
        }

        $fileIds = [];
        foreach ($files as $file)
        {
            $model = new CoreFiles();

            $model->file = $file;
            if ( $model->upload($userId, $dir, $code, $comment, $folderId) )
            {
                $fileIds[] = $model->id;
            }
        }

        return $fileIds;
    }

    /* ===== Удалить файлы (Сами файлы && из БД). ===== */
    public static function deleteFiles(array $fileIds)
    {
        $filesPatch = self::find()
            ->select('file_patch')
            ->where(['in', 'id', $fileIds])
            ->column();

        if ($filesPatch)
        {
            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                $appPatch = Yii::getAlias('@app/web');
                if ( !self::deleteAll(['id' => $fileIds]) )
                {
                    throw new \Exception('Error No Delete');
                }

                foreach ($filesPatch as $patch)
                {
                    $fullPatch = $appPatch.$patch;
                    if (is_dir($fullPatch))
                    {
                        if (!unlink($fullPatch))
                        {
                            throw new \Exception('Error No Delete');
                        }
                    }
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
    }

    /* ===== Удалить только файлы. ===== */
    public static function deleteFilesByPatch(array $filesPatch)
    {
        $appPatch = Yii::getAlias('@app/web');
        foreach ($filesPatch as $patch)
        {
            unlink($appPatch.$patch);
        }
    }

    /* ===== Получить захешированный путь. ===== */
    public function getFileHash()
    {
        $this->file_hash = Yii::$app->security->generateRandomString(128);
    }

    /* ===== Загрузка файлов. ===== */
    public function upload(?int $userId = null, string $dir = self::DIR_UPLOADED_FILES, string $code = self::CODE_EDU, ?string $comment = null, ?int $folderId = null)
    {
        if (!isset($userId))
        {
            $userId = Yii::$app->user->id;
        }

        $appPatch = Yii::getAlias('@app/web');
        $dirPatch = "/{$dir}/user_id_{$userId}/" . date('Y-m-d');
        if (!is_dir($appPatch.$dirPatch))
        {
            mkdir($appPatch.$dirPatch, 0777, true);
        }

        $fileExtension = $this->file->extension;
        $filePatch = "{$dirPatch}/" . uniqid(80) . '.' . $fileExtension;

        $this->file_user_id     = $userId;
        $this->file_folder_id   = $folderId;
        $this->file_title       = $this->file->name;
        $this->file_patch       = $filePatch;
        $this->file_comment     = $comment;
        $this->file_extension   = $fileExtension;
        $this->file_size        = $this->file->size;
        $this->file_code        = $code;
        self::getFileHash();

        if ($this->validate() && $this->file->error === UPLOAD_ERR_OK)
        {
            if ($this->file->saveAs($appPatch.$filePatch) && $this->save(false))
            {
                return true;
            }
        }

        return false;
    }
}
