<?php

namespace app\modules\edu\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class EduSpecialisation extends ActiveRecord
{
    const STATUS_ACTIVE         = 'active';
    const STATUS_DEACTIVATED    = 'deactivated';

    const STATUS_ALL = [
        self::STATUS_ACTIVE,
        self::STATUS_DEACTIVATED,
    ];

    public static function tableName()
    {
        return '{{%edu_specialisation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fgos', 'code'], 'required'],
            [['name', 'fgos', 'code'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
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
            'name'                      => Yii::t('app', 'Название'),
            'fgos'                      => Yii::t('app', 'Название федерального гос. образовательного стандарта'),
            'code'                      => Yii::t('app', 'Код квалификации'),
            'status'                    => Yii::t('app', 'Статус'),
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

    /* ===== Получить список предметов. ===== */
    public static function getSpecialisationsList(?string $status = self::STATUS_ACTIVE): array
    {
        $query = self::find()
            ->select(['id', 'name'])
            ->andFilterWhere(['=', 'status', $status])
            ->orderBy('name ASC')
            ->asArray()
            ->all();

        return ArrayHelper::map($query, 'id', 'name');
    }
}