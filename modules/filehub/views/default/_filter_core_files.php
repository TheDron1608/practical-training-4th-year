<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\core\models\CoreFiles $model */

?>

<?php $form = ActiveForm::begin([
    'method'    => 'GET',
    'options'   => [
        'data-pjax' => 1,
    ]
]); ?>

    <div class="row">

        <div class="col-sm-6 mb-3">
            <?= $form->field($model, 'file_title') ?>
        </div>

<!--        <div class="col-sm-6 mb-3">-->
<!--            --><?//= $form->field($model, 'file_extension') ?>
<!--        </div>-->

    </div>

    <div>
        <?= Html::submitButton('<i class="bi bi-search"></i>', [
            'class' => 'button button__icon button__gray filemanager-content__header-button'
        ]) ?>
    </div>

<?php ActiveForm::end(); ?>