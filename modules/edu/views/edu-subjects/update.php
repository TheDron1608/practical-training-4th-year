<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjects $model */

$this->title = Yii::t('app', 'Редактировать: {name}', [
    'name' => $model->subject_title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Предметы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');

?>

<div class="edu-subjects-update">

    <div class="card">
        <div class="card-content">
            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <?= $this->render('_form', [
                'model'     => $model,
                'isUpdate'  => true,
            ]) ?>
        </div>
    </div>

</div>
