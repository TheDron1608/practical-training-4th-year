<?php

use app\modules\edu\models\EduQualifications;
use app\modules\edu\models\EduSpecialisation;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduQualifications $model */
/** @var yii\widgets\ActiveForm $form */
/** @var bool|null $isUpdate */

?>

<div class="edu-qualifications-form">

    <?php if (!isset($isUpdate) || !$isUpdate): ?>
        <div>
            <?= Html::a(Yii::t('app', 'Прикрепить файл'), false, [
                'class'             => Yii::$app->params['btnPrimaryClass'],
                'data-bs-toggle'    => 'modal',
                'data-bs-target'    => '#my-modal',
                'id'                => 'upload-modal-button',
                'value'             => Url::to(['add-file']),
            ]) ?>
        </div>
        <hr>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'qualification_title')->textInput([
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

    <div class="mb-3">
        <?= $form->field($model, 'qualification_about')->textarea([
            'class'     => 'input',
            'maxlength' => true,
        ]) ?>
    </div>

    <?php if (isset($isUpdate) && $isUpdate): ?>
        <div class="mb-3">
            <?= $form->field($model, 'status')->radioList(EduQualifications::getStatusAll()) ?>
        </div>
    <?php endif; ?>

    <div class="col-md-6 mb-3">
        <?= $form->field($model, 'year')->textInput(['type' => 'number', 'value' => date('Y')]) ?>
    </div>

    <div class="col-md-6 mb-3">
        <?= $form->field($model, 'base_education')->dropDownList(['9' => '9 класс', '11' => '11 класс']) ?>
    </div>

    <div class="col-md-6 mb-3">
        <?= $form->field($model, 'specialisation_id')->widget(Select2::class, [
            'data'      => EduSpecialisation::getSpecialisationsList(),
            'options'   => [
                'prompt' => '...',
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