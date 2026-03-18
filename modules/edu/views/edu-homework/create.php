<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduHomework $model */

$this->title = Yii::t('app', 'Отправить ДЗ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ДЗ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edu-homework-create">

    <div class="card">
        <div class="card-content">
            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
