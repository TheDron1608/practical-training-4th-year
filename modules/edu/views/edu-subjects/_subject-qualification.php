<?php
use yii\helpers\Html;
?>

<div class="bg-light rounded-1 p-1 mb-1 justify-content-between">
    <h6 class="col-12"><?= Html::encode($model->qualification->qualification_title) ?></h6>
    <p class="col-6">Код: <?= Html::encode($model->code) ?></p>
    <p class="col-6">Часы: <?= Html::encode($model->hours) ?></p>
</div>