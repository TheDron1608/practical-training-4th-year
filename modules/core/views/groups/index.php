<?php

use app\modules\core\models\Groups;
use app\modules\edu\models\EduSpecialisation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\core\models\GroupsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Группы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-index">

    <p>
        <?= Html::a(Yii::t('app', 'Создать'), ['create'], ['class' => Yii::$app->params['btnSuccessClass']]) ?>
    </p>
    <hr>

    <?php Pjax::begin(['timeout' => false]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'group_title',
            [
                'attribute' => 'group_curator_id',
                'format'    => 'raw',
                'filter'    => Groups::getAllCurators(),
                'value' => function (Groups $model) {
                    if ($model->group_curator_id === null) return null;
                    return $model->groupCurator->getUserFio();
                }
            ],
            [
                'attribute' => 'group_specialisation_id',
                'format'    => 'raw',
                'filter' => EduSpecialisation::getSpecialisationsList(),
                'value' => function (Groups $model) {
                    if (!empty($model->groupSpecialisation))
                    {
                        return $model->groupSpecialisation->name;
                    }
                }
            ],
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'filter'    => Groups::STATUS_TYPE,
                'value' => function ($model) {
                    return Groups::STATUS_TYPE[$model->status];
                }
            ],
            [
                'attribute' => 'date',
                'label' => Yii::t('app', ''),
                'format'    => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at) . '/' . Yii::$app->formatter->asDatetime($model->updated_at);
                }
            ],

            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Groups $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [
                    'addUser' => function ($url, $model, $key) 
                    { 
                        return Html::a(Html::img('@web/static_img/add_user.png', [
                            'height' => '20px',
                            'width' => '20px'
                            ]),
                            ['/core/groups/add-users', 'groupId' => $model->id],
                            ['title' => 'Добавить студентов в группу']
                        );
                    }
                ],
                'template' => "{view}\n{update}\n{delete}\n{addUser}",
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
