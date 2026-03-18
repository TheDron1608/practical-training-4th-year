<?php

/* @var \yii\web\View $this */
/* @var \app\modules\core\models\Groups $model */
/* @var array $usersGroup */

use app\modules\core\models\GroupsUsers;
use app\modules\core\models\User;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Группа: {title}', [
    'title' => $model->group_title,
]);

?>

<div class="card mb-3">
    <div class="card-content">
        <?= Html::encode($this->title) ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

<!--        --><?php
//            Modal::begin([
//                'toggleButton' => [
//                    'label' => Yii::t('app', 'Добавить файл'),
//                    'class' => Yii::$app->params['btnPrimaryClass'],
//                ],
//            ]);
//
//            echo $form->field($model, 'group_users_file')->fileInput();
//            echo Html::submitButton(Yii::t('app', 'Send'), ['class' => Yii::$app->params['btnSuccessClass']]);
//
//            Modal::end();
//        ?>

        <?= $form->field($model, 'group_users')->widget(MultipleInput::class, [
            'allowEmptyList'    => false,
            'enableGuessTitle'  => true,
            'addButtonPosition' => MultipleInput::POS_HEADER,
            'columns' => [
                [
                    'name'  => 'user_id',
                    'title' => Yii::t('app', 'Студенты'),
                    'type'  => Select2::class,
                    'options' => [
                        'data' => User::getUserList(null, User::ROLE_USER),
                    ]
                ],

                [
                    'name'  => 'user_role',
                    'title' => Yii::t('app', 'Роли'),
                    'type'  => 'dropDownList',
                    'items' => [
                        GroupsUsers::ROLE_USER  => Yii::t('app', 'Студент'),
                        GroupsUsers::ROLE_MODER => Yii::t('app', 'Модератор')
                    ],
                    'headerOptions' => [
                        'style' => 'width: 20%',
                    ]
                ],
            ]
        ])->label(false) ?>

        <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => Yii::$app->params['btnSuccessClass']]) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>