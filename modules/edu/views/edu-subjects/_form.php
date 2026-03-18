<?php

use app\modules\core\models\User;
use app\modules\edu\models\EduQualifications;
use app\modules\edu\models\EduSubjects;
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
            <?= $form->field($model, 'subject_teacher_id')->widget(Select2::class, [
                'data'      => User::getUserList(null, User::ROLE_TEACHER),
                'options'   => [
                    'prompt' => '...',
                ]
            ]) ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'temp_qualification_input')->widget(MultipleInput::class, [
                'allowEmptyList'    => false,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_HEADER,
                'columns' => [
                    [
                        'name'  => 'qualification_id',
                        'title' => Yii::t('app', 'Квалификация'),
                        'type'  => Select2::class,
                        'options' => [
                            'data' => EduQualifications::getEduQualificationsList()
                        ]
                    ],

                    [
                        'name'  => 'code',
                        'title' => Yii::t('app', 'Индекс'),
                        'type'  => 'textInput'
                    ],

                    [
                        'name'  => 'hours',
                        'title' => Yii::t('app', 'Часы'),
                        'type'  => 'textInput',
                        'options' => [
                            'type' => 'number',
                            'min' => 1
                        ]
                    ],
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
