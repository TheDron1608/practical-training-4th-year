<?php

use app\modules\filehub\models\FilehubFolders;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\filehub\models\FilehubFolders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="filehub-folders-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'folder_title')->textInput([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'folder_about')->textarea([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <?php if (isset($isAdministrationSite) && $isAdministrationSite): ?>
        <div class="mb-3">
            <?= $form->field($model, 'folder_code')->radioList(FilehubFolders::CODE_TYPE)->label(false) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>