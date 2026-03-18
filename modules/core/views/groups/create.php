<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\core\models\Groups $model */

$this->title = Yii::t('app', 'Создать группу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Группы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="groups-create">

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
