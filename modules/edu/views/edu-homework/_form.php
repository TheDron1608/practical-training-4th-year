<?php

use app\modules\core\models\Groups;
use app\modules\core\models\User;
use app\modules\edu\models\EduSubjects;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduHomework $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="edu-homework-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'homework_user_id')->widget(Select2::class, [
                'data'      => User::getUserList(null, User::ROLE_USER),
                'options'   => [
                    'placeholder' => '...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('app', 'Студент')) ?>
        </div>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'homework_group_id')->widget(Select2::class, [
                'data'      => Groups::getGroupList(),
                'options'   => [
                    'placeholder' => '...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'homework_subject_id')->widget(Select2::class, [
                'data'      => EduSubjects::getSubjectsList(),
                'options'   => [
                    'placeholder' => '...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'homework_files')->widget(FileInput::class, [
                'options' => [
                    'multiple'=>true
                ],
                'pluginOptions' => [
                    'showPreview'   => false,
                    'showCaption'   => true,
                    'showRemove'    => false,
                    'showUpload'    => false
                ]
            ])->label(Yii::t('app', 'Файлы')) ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'homework_title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'homework_content')->textarea(['maxlength' => true]) ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'homework_deadline')->widget(DatePicker::class) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
