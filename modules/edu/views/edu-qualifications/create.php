<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduQualifications $model */

$this->title = Yii::t('app', 'Создать квалификацию');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Квалификации'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="edu-qualifications-create">

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
