<?php

namespace app\modules\filehub\models;

use app\modules\core\models\CoreFiles;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * @property mixed|null id
 * @property int|mixed|null folder_owner_id
 * @property mixed|null folder_parent_id
 * @property mixed|null folder_title
 * @property mixed|string|null folder_code
 * @property mixed|string|null status
 * @property mixed|null created_at
 */
class FilehubFolders extends ActiveRecord
{
    const CODE_MY       = 'my';
    const CODE_COMMON   = 'common';

    const CODE_ALL  = [
        self::CODE_MY,
        self::CODE_COMMON,
    ];

    const CODE_TYPE  = [
        self::CODE_MY       => 'Мои',
        self::CODE_COMMON   => 'Общие',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT  = 'draft';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DRAFT,
    ];

    public static function tableName()
    {
        return '{{%filehub_folders}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute'    => 'created_at',
                'updatedAtAttribute'    => false,
                'value' => time(),
            ]
        ];
    }

    public function rules()
    {
        return [
            [['folder_owner_id', 'folder_title'], 'required'],
            [['folder_owner_id', 'folder_parent_id', 'created_at'], 'integer'],
            [['folder_title'], 'string', 'max' => 255],
            [['folder_about'], 'string', 'max' => 1024],
            ['folder_code', 'default', 'value' => self::CODE_MY],
            ['folder_code', 'in', 'range' => self::CODE_ALL],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
        ];
    }

    public function getFolderParent()
    {
        return $this->hasOne(self::class, ['id' => 'folder_parent_id']);
    }

    public function attributeLabels()
    {
        return [
            'folder_title'  => Yii::t('app', 'Название'),
            'folder_about'  => Yii::t('app', 'О папке'),
            'status'        => Yii::t('app', 'Статус'),
            'created_at'    => Yii::t('app', 'Дата создания'),
        ];
    }

    /* ===== Получить папки. ===== */
    public static function getFolders(int $ownerId, ?string $code = self::CODE_MY, ?string $status = self::STATUS_ACTIVE, bool $isArrayMap = true)
    {
        $folders = self::find()
            ->where(['folder_owner_id' => $ownerId])
            ->andFilterWhere(['=', 'folder_code', $code])
            ->andFilterWhere(['=', 'status', $status])
            ->asArray()
            ->all();

        if ($isArrayMap)
        {
            return ArrayHelper::map($folders, 'id', 'folder_title');
        }
    }

    /* ===== Создать / Редактировать папку. ===== */
    public function setFolder(array $data, int $userId, ?int $parentId = null, ?bool $isUserCreateInCommon = null, bool $isUpdate = false, string $formName = 'FilehubFolders')
    {
        if ($this->load($data, $formName))
        {
            if (!$isUpdate)
            {
                $this->folder_owner_id = $userId;
                $this->folder_parent_id = $parentId;
            }

            // ----- Проверка: Может ли пользователь загружать в общий список.
            if ($this->folder_code == self::CODE_COMMON)
            {
                if (!isset($isUserCreateInCommon) || !$isUserCreateInCommon)
                    return false;
            }

            if ($this->save())
            {
                return true;
            }
        }

        return false;
    }

    /* ===== Удалить папку. ===== */
    public function deleteFolder(int $userId)
    {
        if (self::isUserFolderOwner($userId))
        {
            $transaction = Yii::$app->db->beginTransaction();

            try
            {
                $fileIds = CoreFiles::find()
                    ->select('id')
                    ->where(['file_user_id' => $userId])
                    ->andWhere(['file_folder_id' => $this->id])
                    ->column();

                if (!$this->delete())
                {
                    throw new \Exception('Error No Delete Folder');
                }

                if (!empty($fileIds))
                {
                    if (!CoreFiles::deleteFiles($fileIds))
                    {
                        throw new \Exception('Error No Delete Files');
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

        return false;
    }

    /* ===== Проверка: Является ли пользователь автором. ===== */
    public function isUserFolderOwner(int $userId, bool $isForbidden = true): bool|ForbiddenHttpException
    {
        if ($this->folder_owner_id == $userId)
        {
            return true;
        }

        if ($isForbidden)
        {
            throw new ForbiddenHttpException(Yii::t('app', 'Forbidden'));
        }

        return false;
    }
}