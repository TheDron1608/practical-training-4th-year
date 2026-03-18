<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjects $model */

$this->title = Yii::t('app', 'Добавить предмет');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Предметы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="edu-subjects-create">

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
