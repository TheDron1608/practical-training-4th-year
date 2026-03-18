<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\filehub\models\FilehubFolders $model */
/** @var bool $isAdministrationSite */

$this->title = Yii::t('app', 'Редактировать: {name}', [
    'name' => $model->folder_title,
]);
$this->params['breadcrumbs'][] = ['label' => $model->folder_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');

?>

<div class="filehub-folders-update">

    <div class="card">
        <div class="card-content">
            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <?= $this->render('_form', [
                'model'                 => $model,
                'isAdministrationSite'  => $isAdministrationSite,
            ]) ?>
        </div>
    </div>

</div>
