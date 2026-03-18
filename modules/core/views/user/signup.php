<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\modules\core\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">

    <div class="card">
        <div class="card-content">
            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'user_f')->textInput([
                'class'     => 'input',
                'autofocus' => true,
            ]) ?>

            <?= $form->field($model, 'user_i')->textInput([
                'class' => 'input'
            ]) ?>

            <?= $form->field($model, 'user_o')->textInput([
                'class' => 'input'
            ]) ?>

            <?= $form->field($model, 'email')->textInput([
                'class' => 'input'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'input'
            ]) ?>

            <div class="form-group">
                <div class="offset-lg-1 col-lg-11">
                    <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
