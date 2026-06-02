<?php

use app\modules\core\models\Groups;
use app\modules\core\models\User;
use app\modules\edu\models\EduCycle;
use app\modules\edu\models\EduQualifications;
use app\modules\edu\models\EduSubjects;
use app\modules\edu\models\EduSubjectsGroups;
use app\modules\edu\models\SubjectQualification;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjects $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="edu-subjects-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'subject_title')->textInput([
                'class'     => 'input',
                'maxlength' => true,
            ]) ?>
        </div>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'cycle_id')->widget(Select2::class, [
                'data'      => EduCycle::getCycleList(),
                'options'   => [
                    'prompt' => '...',
                ]
            ]) ?>
        </div>

        

        <div class="mb-3">
            <?= $form->field($model, 'subject_about')->textarea([
                'class'     => 'input',
                'maxlength' => true,
            ]) ?>
        </div>

        <?php if (isset($isUpdate) && $isUpdate): ?>
            <div class="mb-3">
                <?= $form->field($model, 'status')->radioList(EduSubjects::getStatusAll()) ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
