<?php

use app\modules\core\models\helpers\MessageHelper;
use app\modules\edu\models\EduQualifications;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjects $model */

$this->title = $model->qualification_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Квалификации'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="edu-subjects-view">

    <div class="card">
        <div class="card-content">

            <h4><?= $this->title ?></h4>
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
                            <td><?= Yii::t('app', 'О квалификации') ?></td>
                            <td><?= html::encode($model->qualification_about) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Год') ?></td>
                            <td><?= html::encode($model->year) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Специальность') ?></td>
                            <td><?= html::encode($model->specialisation->name) ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Базовое образование') ?></td>
                            <td><?= html::encode($model->base_education . " класс") ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Статус') ?></td>
                            <td><?= EduQualifications::getStatusAll()[$model->status] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <h4>Предметы по квалификации</h4>
                <br>

                <?php foreach ($model->subjectQualifications as $qualification): ?>
                    <?= $this->render('_subject-qualification', ['model' => $qualification]) ?>
                <?php endforeach ?>
                
                <br>
                <p>
                    <?= Html::a(Yii::t('app', 'Создать новый предмет по квалификации'), ['add-subject-qualification', 'id' => $model->id], ['class' => "btn btn-success w-50"]) ?>
                </p>
            </div>
        </div>
    </div>

</div>
