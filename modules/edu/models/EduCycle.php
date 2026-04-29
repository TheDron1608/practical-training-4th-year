<?php

namespace app\modules\edu\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class EduCycle extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%edu_cycle}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'code'], 'required'],
            [['id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('app', 'ID'),
            'name'  => Yii::t('app', 'Название'),
            'code'  => Yii::t('app', 'Код'),
        ];
    }

    public static function getCycleList(): array
    {
        $cycleList = self::find()
            ->select([
                'id',
                'name'
            ])
            ->asArray()
            ->all();

        return ArrayHelper::map($cycleList, 'id', 'name');
    }
}