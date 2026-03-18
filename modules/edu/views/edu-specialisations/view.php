<?php

use app\modules\core\models\helpers\MessageHelper;
use app\modules\edu\models\EduSubjects;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjects $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Специальности'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="edu-subjects-view">

    <div class="card">
        <div class="card-content">

            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <div class="icons-list card-content__icons mb-3">
                <div class="icon">
                    <?= Html::a('<i class="bi bi-pencil-square"></i>', ['update', 'id' => $model->id]) ?>
                </div>
                <div class="icon">
                    <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => MessageHelper::messages()[MessageHelper::KEY_CONFIRM],
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>

            <div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td><?= Yii::t('app', 'Название') ?></td>
                            <td><?= html::encode($model->name) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Название фгос') ?></td>
                            <td><?= html::encode($model->fgos) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Код квалификации') ?></td>
                            <td><?= html::encode($model->code) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Статус') ?></td>
                            <td><?= EduSubjects::getStatusAll()[$model->status] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
