<?php

use app\modules\edu\models\EduQualifications;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduQualifications $model */
/** @var yii\widgets\ActiveForm $form */
/** @var bool|null $isUpdate */

?>

<div class="edu-qualifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'name')->textInput([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'fgos')->textInput([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'code')->textInput([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

Modal::begin([
    'id'   => 'my-modal',
    'size' => 'modal-lg'
]);

Pjax::begin(['id' => 'my-modal-content', 'timeout' => FALSE, 'enablePushState' => FALSE,]);

Pjax::end();

Modal::end();

$js = <<< JS
    $("document").ready(function () {
        
        $(document).on('click', '#upload-modal-button', function(){
            $('#my-modal').find('#my-modal-content').load($(this).attr('value'), $(this));
            
            $("#my-modal").on("pjax:end", function(data) {
                $.pjax.reload({container:"#opp-modules"});  
            });   
        });
        
    });
JS;

$this->registerJs($js,View::POS_READY, null);