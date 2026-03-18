<?php

use app\modules\core\models\helpers\MessageHelper;
use app\modules\edu\models\EduSubjects;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjects $model */

$this->title = $model->subject_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Предметы'), 'url' => ['index']];
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
                            <td><?= Yii::t('app', 'Преподаватель') ?></td>
                            <td><?= $model->subjectTeacher->getUserFio() ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Квалификации') ?></td>
                            <td>
                                <ul class="list-group">
                                    <?php foreach ($model->subjectQualifications as $subjectQualification): ?>
                                        <li><?= $this->render('_subject-qualification', ['model' => $subjectQualification]) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Предмет') ?></td>
                            <td><?= $model->subject_title ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'О предмете') ?></td>
                            <td><?= $model->subject_about ?></td>
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
