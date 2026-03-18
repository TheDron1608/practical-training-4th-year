<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\filehub\models\FilehubFolders $model */
/** @var bool $isAdministrationSite */

$this->title = Yii::t('app', 'Создать');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="filehub-folders-create">

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
