<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\filehub\models\FilehubFoldersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="filehub-folders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'folder_owner_id') ?>

    <?= $form->field($model, 'folder_parent_id') ?>

    <?= $form->field($model, 'folder_title') ?>

    <?= $form->field($model, 'folder_about') ?>

    <?php // echo $form->field($model, 'folder_code') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
