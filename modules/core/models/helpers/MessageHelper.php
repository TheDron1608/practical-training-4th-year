<?php


namespace app\modules\core\models\helpers;


use Yii;

class MessageHelper
{
    const KEY_SUCCESS   = 'success';
    const KEY_DANGER    = 'danger';
    const KEY_CONFIRM   = 'confirm';
    const KEY_FORBIDDEN = 'forbidden';

    public static function messages(): array
    {
        return [
            self::KEY_SUCCESS   => Yii::t('app', 'Успешно!'),
            self::KEY_DANGER    => Yii::t('app', 'Ошибка!'),
            self::KEY_CONFIRM   => Yii::t('app', 'Вы точно уверены, что хотите удалить?'),
            self::KEY_FORBIDDEN => Yii::t('app', 'Запрещено!'),
        ];
    }
}