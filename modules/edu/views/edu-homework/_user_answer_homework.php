<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\edu\models\EduHomework $model */

?>

<div>

    <?php $form = ActiveForm::begin(); ?>

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