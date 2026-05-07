<?php

use app\modules\core\models\Groups;
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
/** @var app\modules\edu\models\EduMySubjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Мои Предметы');
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

                'subject_title',
                [
                    'attribute' => 'subject_groups',
                    'format'    => 'raw',
                    'filter'    => Select2::widget([
                        'name'      => 'EduSubjectsSearch[group_id]',
                        'value'     => $searchModel->group_id,
                        'data'      => Groups::getGroupList(),
                        'options'   => [
                            'prompt' => '...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function (EduSubjects $model) {
                        $result = "";
                        foreach ($model->eduSubjectsGroups as $subjectGroup)
                        {
                            $result .= $this->render('_subject-group-no-teacher', ['model' => $subjectGroup, 'showTeacher' => false]);
                        }
                        return $result;
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
