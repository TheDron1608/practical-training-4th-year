<?php

use app\modules\core\models\User;
use app\modules\edu\models\EduSpecialisation;
use app\modules\edu\models\EduSubjects;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\core\models\Groups $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="groups-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}<br>{input}<br>{error}",
        ],
    ]); ?>

    <div class="mb-3">
        <?= $form->field($model, 'group_curator_id')->widget(Select2::class, [
            'data'      => User::getUserList(null, User::ROLE_TEACHER) + User::getUserList(null, User::ROLE_CURATOR),
            'options'   => [
                'prompt' => Yii::t('app', '...')
            ]
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'group_specialisation_id')->widget(Select2::class, [
            'data'      => EduSpecialisation::getSpecialisationsList(),
            'options'   => [
                'prompt' => Yii::t('app', '...')
            ]
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'group_title')->textInput([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'group_about')->textarea([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'group_subjects')->widget(Select2::class, [
            'data'      => EduSubjects::getSubjectsList(),
            'options'   => [
                'placeholder'   => '...',
                'multiple'      => true
            ]
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>