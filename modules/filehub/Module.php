<?php

namespace app\modules\filehub;

use yii\filters\AccessControl;

/**
 * filehub module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\filehub\controllers';

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
                            'roles' => ['@'],
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
