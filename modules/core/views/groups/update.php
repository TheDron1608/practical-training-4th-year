<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\core\models\Groups $model */

$this->title = Yii::t('app', 'Редактировать группу: {name}', [
    'name' => $model->group_title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Группы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->group_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');

?>

<div class="groups-update">

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
