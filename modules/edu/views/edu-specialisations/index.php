<?php

use app\modules\edu\models\EduSpecialisation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduSubjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var ?bool $isAdministrationSite */

$this->title = Yii::t('app', 'Специальности');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="edu-subjects-index">

    <p>
        <?= Html::a(Yii::t('app', 'Создать'), ['create'], ['class' => Yii::$app->params['btnSuccessClass']]) ?>
    </p>
    <hr>

    <?php Pjax::begin(['timeout' => false]); ?>

    <div class="grid-overflow">
        <?= GridView::widget([
            'dataProvider'  => $dataProvider,
            //'filterModel'   => $searchModel, 
            //в данный момент не используется, так как пока что нету полей для фильтрации кроме ID, фильтрация уже есть, раскоментируйте для её реализации
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'fgos',
                'code',
                [
                    'attribute' => 'status',
                    'format'    => 'raw',
                    'filter'    => EduSpecialisation::getStatusAll(),
                    'visible'   => $isAdministrationSite ?? false,
                    'value' => function (EduSpecialisation $model) {
                        return EduSpecialisation::getStatusAll()[$model->status];
                    }
                ],

                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, EduSpecialisation $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => "{view}\n{update}\n{delete}"
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
