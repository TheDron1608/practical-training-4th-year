<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\edu\models\EduHomeworkUsers $model */

?>

<div>

    <?php $form = ActiveForm::begin([
        'id' => 'answer-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

    <div class="mb-3">
        <?= $form->field($model, 'answer_files[]')->fileInput(['multiple' => true])->label(Yii::t('app', 'Файлы')) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'homework_answer_comment')->textarea() ?>
    </div>

    <div>
        <?= Html::submitButton(Yii::t('app', 'Отправить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>