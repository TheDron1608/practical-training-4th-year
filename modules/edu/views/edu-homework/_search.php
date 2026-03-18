<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduHomeworkSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="edu-homework-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'homework_teacher_id') ?>

    <?= $form->field($model, 'homework_user_id') ?>

    <?= $form->field($model, 'homework_group_id') ?>

    <?= $form->field($model, 'homework_subject_id') ?>

    <?php // echo $form->field($model, 'homework_answer_file_id') ?>

    <?php // echo $form->field($model, 'homework_file_ids') ?>

    <?php // echo $form->field($model, 'homework_title') ?>

    <?php // echo $form->field($model, 'homework_content') ?>

    <?php // echo $form->field($model, 'homework_deadline') ?>

    <?php // echo $form->field($model, 'homework_grade') ?>

    <?php // echo $form->field($model, 'homework_options') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
