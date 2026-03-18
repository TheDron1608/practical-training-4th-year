<?php

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\base\DynamicModel $model */
/** @var array $getFolders */

?>

<div>

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!isset($folderId)): ?>
        <div class="mb-3">
            <?= $form->field($model, 'folder_id')->widget(Select2::class, [
                'data'      => $getFolders,
                'options'   => [
                    'placeholder'   => '...',
                ]
            ])->label(Yii::t('app', 'Папка')) ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <?= $form->field($model, 'upload_files')->widget(FileInput::class, [
            'options' => [
                'multiple'=>true
            ],
            'pluginOptions' => [
                'showPreview'   => true,
                'showCaption'   => true,
                'showRemove'    => false,
                'showUpload'    => false
            ]
        ])->label(false) ?>
    </div>

    <div>
        <?= Html::submitButton(Yii::t('app', 'Отправить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>