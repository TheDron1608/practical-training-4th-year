<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduQualifications $model */

$this->title = Yii::t('app', 'Редактировать: {name}', [
    'name' => $model->qualification_title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Квалификация'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактировать');
?>

<div class="edu-qualifications-update">

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
