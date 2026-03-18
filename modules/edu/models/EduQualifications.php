<?php

namespace app\modules\edu\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%edu_qualifications}}".
 *
 * @property int $id
 * @property string $qualification_title
 * @property string|null $qualification_about
 * @property string $status
 */
class EduQualifications extends ActiveRecord
{
    const STATUS_ACTIVE         = 'active';
    const STATUS_DEACTIVATED    = 'deactivated';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DEACTIVATED,
    ];

    public static function tableName()
    {
        return '{{%edu_qualifications}}';
    }

    public $file;

    public function rules()
    {
        return [
            [['qualification_title', 'year', 'specialisation_id', 'base_education'], 'required'],
            [['code'], 'string'],
            [['qualification_title'], 'string', 'max' => 255],
            [['qualification_about'], 'string', 'max' => 4096],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => self::STATUS_ALL],
            ['file', 'file', 'extensions' => 'txt',
                'maxFiles' => 1, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    => Yii::t('app', 'ID'),
            'qualification_title'   => Yii::t('app', 'Название'),
            'qualification_about'   => Yii::t('app', 'О квалификации'),
            'status'                => Yii::t('app', 'Статус'),
            'specialisation_id'     => Yii::t('app', 'Специальность'),
            'base_education'        => Yii::t('app', 'Базовое образование'),
            'year'                  => Yii::t('app', 'Год начала обучения'),
            'code'                  => Yii::t('app', 'Код квалификации'),
            'specialisation'        => Yii::t('app', 'Специальность')
        ];
    }

    #[ArrayShape([self::STATUS_ACTIVE => "string", self::STATUS_DEACTIVATED => "string"])]
    public static function getStatusAll(): array
    {
        return [
            self::STATUS_ACTIVE         => Yii::t('app', 'Активен'),
            self::STATUS_DEACTIVATED    => Yii::t('app', 'Деактивирован'),
        ];
    }

    public static function getYearsAll(): array
    {
        return array_map(fn (array $e) => $e['year'],
            self::find()
            ->select('year')
            ->distinct()
            ->orderBy('year ASC')
            ->asArray()
            ->all(),
        );
    }

    /* ===== Получить список квалификаций. ===== */
    public static function getEduQualificationsList(?string $status = self::STATUS_ACTIVE): array
    {
        $query = self::find()
            ->select([
                'id',
                'qualification_title',
            ])
            ->andFilterWhere(['=', 'status', $status])
            ->orderBy('qualification_title ASC')
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'qualification_title');
    }

    /* ===== Множественное создание квалификаций. ===== */
    public static function multipleCreateQualifications(array $qualifications): bool|int
    {
        $arrQualifications = [];

        foreach ($qualifications as $qualification)
        {
            $arrQualifications[] = [
                'qualification_title'   => $qualification,
                'qualification_about'   => null,
                'status'                => self::STATUS_ACTIVE,
            ];
        }

        if (!empty($arrQualifications))
        {
            return  Yii::$app->db->createCommand()
                ->batchInsert(self::tableName(), ['qualification_title', 'qualification_about', 'status'], $arrQualifications)
                ->execute();
        }

        return false;
    }

    //Не используется, заменsён на EduQualification
    /* ===== Создание / Редактирование квалификаций. ===== */
    /*public function setEduQualifications(array $data, bool $isUploadFile = false, string $formName = 'EduQualifications')
    {
        if ($this->load($data, $formName))
        {
            if (!$isUploadFile)
            {
                if ($this->file = UploadedFile::getInstance($this, 'file'))
                {
                    $path = Yii::getAlias('@app') . "/web/" . CoreFiles::DIR_TEMP_FILES . "/{$this->file->name}.{$this->file->extension}";
                    if (!$this->file->saveAs($path))
                    {
                        return false;
                    }

                    $items = file($path);
                    unlink($path);

                    if (empty($items))
                    {
                        return false;
                    }

                    return self::multipleCreateQualifications($items);
                }
            }

            return $this->save();
        }

        return false;
    }*/

    public function GetSpecialisation()
    {
        return $this->hasOne(EduSpecialisation::class, ['id' => 'specialisation_id']);
    }
}