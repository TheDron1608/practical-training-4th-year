<?php

use app\modules\edu\models\EduHomework;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduHomeworkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $isTeacher */

$this->title = Yii::t('app', 'ДЗ');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="edu-homework-index">

    <?php if ($isTeacher): ?>
        <div>
            <?= Html::a(Yii::t('app', 'Отправить ДЗ'), ['create'], [
                'class' => Yii::$app->params['btnSuccessClass'],
            ]) ?>
        </div>
        <hr>
    <?php endif; ?>

    <?php Pjax::begin(['timeout' => false]); ?>

    <div class="grid-overflow">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'teacher',
                    'format'    => 'raw',
                    'value' => function (EduHomework $model) {
                        return $model->homeworkTeacher->getUserFio();
                    }
                ],
                [
                    'attribute' => 'group',
                    'format'    => 'raw',
                    'value' => function (EduHomework $model) {
                        return Html::a($model->homeworkGroup->group_title, [Url::to('/core/groups/view'), 'id' => $model->homework_group_id], [
                            'data-pjax' => 0,
                        ]);
                    }
                ],
                [
                    'attribute' => 'subject',
                    'format'    => 'raw',
                    'value' => function (EduHomework $model) {
                        return $model->homeworkSubject->subject_title;
                    }
                ],
                'homework_title',
                'homework_deadline',
                [
                    'attribute' => 'created_at',
                    'format'    => 'raw',
                    'filter'    => false,
                    'value' => function (EduHomework $model) {
                        return Yii::$app->formatter->asDatetime($model->created_at);
                    }
                ],

                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, EduHomework $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => "{view}\n{update}",
                    'buttons' => [
                        'update' => function ($url, $model) use ($isTeacher) {
                            if ($isTeacher)
                            {
                                return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M498 142l-46 46c-5 5-13 5-17 0L324 77c-5-5-5-12 0-17l46-46c19-19 49-19 68 0l60 60c19 19 19 49 0 68zm-214-42L22 362 0 484c-3 16 12 30 28 28l122-22 262-262c5-5 5-13 0-17L301 100c-4-5-12-5-17 0zM124 340c-5-6-5-14 0-20l154-154c6-5 14-5 20 0s5 14 0 20L144 340c-6 5-14 5-20 0zm-36 84h48v36l-64 12-32-31 12-65h36v48z"></path></svg>', $url, [
                                    'data-pjax' => 0,
                                ]);
                            }
                        }
                    ],
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
