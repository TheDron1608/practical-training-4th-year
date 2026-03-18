<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\core\models\User $model */

$this->title = Yii::t('app', 'Редактировать: {name}', [
    'name' => $model->getUserFio(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getUserFio(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="user-update">

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