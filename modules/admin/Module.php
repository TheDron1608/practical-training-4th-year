<?php

namespace app\modules\admin;

use app\modules\core\models\User;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => [User::ROLE_ADMINISTRATOR],
                        ],
                    ],
                ],
            ]
        );
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
