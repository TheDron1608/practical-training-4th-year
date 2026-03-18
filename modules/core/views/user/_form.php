<?php

use app\modules\core\models\Groups;
use app\modules\core\models\User;
use Codeception\Platform\Group;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\modules\core\models\User $model */
/** @var yii\widgets\ActiveForm $form */
/** @var bool $isCreate */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}<br>{input}<br>{error}",
        ],
    ]); ?>

    <div class="row">

        <?php if (!isset($isCreate) || !$isCreate): ?>
            <div class="mb-3">
                <?= $form->field($model, 'avatar')->fileInput() ?>
            </div>
        <?php endif; ?>

        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'user_f')->textInput([
                'class'     =>  'input',
                'maxlength' => true,
            ]) ?>
        </div>

        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'user_i')->textInput([
                'class'     =>  'input',
                'maxlength' => true,
            ]) ?>
        </div>

        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'user_o')->textInput([
                'class'     =>  'input',
                'maxlength' => true,
            ]) ?>
        </div>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'password')->passwordInput([
                'class'     =>  'input',
                'maxlength' => true,
            ]) ?>
        </div>

        <?php if (!isset($isCreate) || !$isCreate): ?>
            <div class="col-md-6 mb-3">
                <?= $form->field($model, 'password_new')->passwordInput([
                    'class'     =>  'input',
                    'maxlength' => true,
                ]) ?>
            </div>

            <div class="col-md-12 mb-3">
                <?= $form->field($model, 'about')->textarea([
                    'class'     => 'input',
                    'maxlength' => true,
                ]) ?>
            </div>
        <?php endif; ?>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'email')->textInput([
                'class'     =>  'input',
                    'maxlength' => true,
                    ]) ?>
        </div>
        
        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'snils')->widget(MaskedInput::class, [
                'class'     => 'input',
                'mask'      => '999-999-999-99',
                ]) ?>
        </div>

        <?php if (isset($isCreate) && $isCreate): ?>
            <div class="col-md-6 mb-3">
                <?= $form->field($model, 'role')->dropDownList( User::getTypeUserRoles([User::ROLE_ADMINISTRATOR]), [
                    'class' => 'input',
                ]) ?>
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