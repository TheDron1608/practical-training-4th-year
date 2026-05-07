<?php


namespace app\modules\core\models;


use Yii;
use yii\helpers\Url;

class Menu
{
    const KEY_LABEL = 'label';
    const KEY_CODE  = 'code';
    const KEY_ITEMS = 'items';
    const KEY_URL   = 'url';
    const KEY_ICON  = 'icon';

    const CODE_DROPDOWN = 'dropdown';

    public static function getMenuElements(array|false $userRoles, int|false $userId): array
    {
        $header = [];

        /** ===== НАЧАЛО: САЙДБАР. ===== */
        if ($userId)
        {
            $sideBare = [
                [
                    self::KEY_LABEL => Yii::t('app', 'Файловый Хаб'),
                    self::KEY_CODE  => self::CODE_DROPDOWN,
                    self::KEY_ICON  => '<i class="bi bi-folder2-open"></i>',
                    self::KEY_ITEMS => [
                        [
                            self::KEY_LABEL => Yii::t('app', 'Общий список'),
                            self::KEY_ICON  => 'ic',
                            self::KEY_URL   => Url::to('/filehub/default/index'),
                        ],
                        [
                            self::KEY_LABEL => Yii::t('app', 'Мой список'),
                            self::KEY_ICON  => 'ic',
                            self::KEY_URL   => Url::to('/filehub/default/my'),
                        ],
                    ],
                ],

                [
                    self::KEY_LABEL => Yii::t('app', 'Дз'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-receipt"></i>',
                    self::KEY_URL   => Url::to('/edu/edu-homework/index'),
                ]
            ];

            /** ===== НАЧАЛО: ДЛЯ УЧИТЕЛЕЙ / ПЕРЕПОДАВАТЕЛЕЙ. ===== */
            if ( array_key_exists(User::ROLE_TEACHER, $userRoles) )
            {
                $sideBare[] = [
                    self::KEY_LABEL => Yii::t('app', 'Мои предметы'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-list-ul"></i>',
                    self::KEY_URL   => Url::to('/edu/edu-subjects/my-subjects'),
                ];

                $sideBare[] = [
                    self::KEY_LABEL => Yii::t('app', 'Отправить Дз'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-receipt"></i>',
                    self::KEY_URL   => Url::to('/edu/edu-homework/create'),
                ];
            }
            /** ===== КОНЕЦ: ДЛЯ УЧИТЕЛЕЙ / ПЕРЕПОДАВАТЕЛЕЙ. ===== */

            /** ===== НАЧАЛО: ДЛЯ АДМИНИСТРАЦИИ САЙТА. ===== */
            if ( array_key_exists(User::ROLE_ADMINISTRATOR, $userRoles) )
            {
                $sideBare[] = [
                    self::KEY_LABEL => Yii::t('app', 'Админ панель'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-grid-3x3-gap"></i>',
                    self::KEY_URL   => Url::to('/admin'),
                ];

                $sideBare[] = [
                    self::KEY_LABEL => Yii::t('app', 'Предметы'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-list-ul"></i>',
                    self::KEY_URL   => Url::to('/edu/edu-subjects/index'),
                ];
            }
            /** ===== КОНЕЦ: ДЛЯ АДМИНИСТРАЦИИ САЙТА. ===== */
        }
        else
        {
            $sideBare = [
                [
                    self::KEY_LABEL => Yii::t('app', 'Регистрация'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-person-fill-down"></i>',
                    self::KEY_URL   => Url::to('/core/user/signup'),
                ],

                [
                    self::KEY_LABEL => Yii::t('app', 'Авторизация'),
                    self::KEY_CODE  => false,
                    self::KEY_ICON  => '<i class="bi bi-person-fill-check"></i>',
                    self::KEY_URL   => Url::to('/core/user/login'),
                ],
            ];
        }
        /** ===== КОНЕЦ: САЙДБАР. ===== */

        return [
            'header'    => $header,
            'sideBare'  => $sideBare,
        ];
    }
}