<?php

use app\modules\core\models\User;
use app\modules\edu\models\EduCycle;
use app\modules\edu\models\EduQualifications;
use app\modules\edu\models\EduSubjects;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var ?bool $isAdministrationSite */

$this->title = Yii::t('app', 'Предметы');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="edu-subjects-index">

    <?php if (isset($isAdministrationSite) && $isAdministrationSite): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Создать'), ['create'], [
                'class' => Yii::$app->params['btnSuccessClass'],
            ]) ?>
        </p>
        <hr>
    <?php endif; ?>

    <?php Pjax::begin(['timeout' => false]); ?>

    <div class="grid-overflow">
        <?= GridView::widget([
            'dataProvider'  => $dataProvider,
            'filterModel'   => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'subject_teacher_id',
                    'format'    => 'raw',
                    'filter'    => Select2::widget([
                        'name'      => 'EduSubjectsSearch[subject_teacher_id]',
                        'value'     => $searchModel->subject_teacher_id,
                        'data'      => User::getUserList(null, User::ROLE_TEACHER),
                        'options'   => [
                            'prompt' => '...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function (EduSubjects $model) {
                        return $model->subjectTeacher->getUserFio();
                    }
                ],
                [
                    'attribute' => 'subject_qualifications',
                    'format'    => 'raw',
                    'filter'    => Select2::widget([
                        'name'      => 'EduSubjectsSearch[subject_qualification_id]',
                        'value'     => $searchModel->subject_qualification_id,
                        'data'      => EduQualifications::getEduQualificationsList(),
                        'options'   => [
                            'prompt' => '...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function (EduSubjects $model) {
                        $result = "";
                        foreach ($model->subjectQualifications as $subjectQualification)
                        {
                            $result .= $this->render('_subject-qualification', ['model' => $subjectQualification]);
                        }
                        return $result;
                    }
                ],
                'subject_title',
                'subject_about',
                [
                    'attribute' => 'cycle_id',
                    'format'    => 'raw',
                    'filter'    => Select2::widget([
                        'name'      => 'EduSubjectsSearch[cycle_id]',
                        'value'     => $searchModel->cycle_id,
                        'data'      => EduCycle::getCycleList(),
                        'options'   => [
                            'prompt' => '...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function (EduSubjects $model) {
                        return $model->cycle->name;
                    }
                ],
                
                [
                    'attribute' => 'status',
                    'format'    => 'raw',
                    'filter'    => EduSubjects::getStatusAll(),
                    'visible'   => $isAdministrationSite ?? false,
                    'value' => function (EduSubjects $model) {
                        return EduSubjects::getStatusAll()[$model->status];
                    }
                ],

                [
                    'class' => ActionColumn::class,
                    'visible' => $isAdministrationSite ?? false,
                    'urlCreator' => function ($action, EduSubjects $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => "{view}\n{update}\n{delete}",
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
