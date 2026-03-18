<?php

use app\modules\edu\models\EduQualifications;
use app\modules\edu\models\EduSpecialisation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduQualificationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = Yii::t('app', 'Квалификации');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="edu-qualifications-index">

    <p>
        <?= Html::a(Yii::t('app', 'Создать'), ['create'], ['class' => Yii::$app->params['btnSuccessClass']]) ?>
    </p>
    <hr>

    <?php Pjax::begin(['timeout' => false]); ?>

    <div class="grid-overflow">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'qualification_title',
                'qualification_about',
                'code',
                [
                    'attribute' => 'year',
                    'filter' => array_combine(EduQualifications::getYearsAll(), EduQualifications::getYearsAll())
                ],
                [

                    'attribute' => 'base_education',
                    'filter' => ['9' => '9 класс', '11' => '11 класс']
                ],
                [
                    'attribute' => 'specialisation_id',
                    'format'    => 'raw',
                    'filter'    => ArrayHelper::map(EduSpecialisation::find()->all(), 'id', 'name'),
                    'value' => function (EduQualifications $model) {
                        return $model->specialisation->name;
                    }
                ],
                [
                    'attribute' => 'status',
                    'format'    => 'raw',
                    'filter'    => EduQualifications::getStatusAll(),
                    'value' => function (EduQualifications $model) {
                        return EduQualifications::getStatusAll()[$model->status];
                    }
                ],

                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, EduQualifications $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => "{view}\n{update}\n{delete}",
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
