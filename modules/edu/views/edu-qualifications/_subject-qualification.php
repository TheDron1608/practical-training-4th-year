<?php
use yii\helpers\Html;

/** @var app\modules\edu\models\EduSubjects $model */
?>

<div class="bg-light rounded-1 p-1 mb-1 justify-content-between">
    <h5 class="col-12"><?= Html::encode($model->subject->subject_title) ?></h5>
    <div class="row">
        <p class="col-1">Код: <?= Html::encode($model->code) ?></p>
        <p class="col-1">Часы: <?= Html::encode($model->hours) ?></p>
    </div>
</div>