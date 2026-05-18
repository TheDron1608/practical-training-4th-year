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

$this->title = Yii::t('app', 'ДЗ');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="edu-homework-index">

    <?php Pjax::begin(['timeout' => false]); ?>

    <div class="grid-overflow">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model) {
                if($model->isOverdued && ($model->answer === null || !$model->answer->isAnswered)){
                    return ['class' => 'bg-danger border-danger'];
                }
            },
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
                    'attribute' => 'subject',
                    'format'    => 'raw',
                    'value' => function (EduHomework $model) {
                        return $model->homeworkSubject->subject_title;
                    }
                ],
                'homework_title',
                'homework_deadline',
                [
                    'attribute' => 'answer',
                    'format'    => 'raw',
                    'value' => function (EduHomework $model) {
                        $answer = $model->answer;
                        $answered = $answer !== null && $answer->isAnswered;
                        if ($model->isOverdued)
                        {
                            if ($answered) 
                            {   
                                return "Ожидает оценки";
                            }
                            else 
                            {
                                return "Задание просрочено";
                            }
                        }
                        else if ($answered)
                        {
                            return Html::a("Ожидает оценки", ['/edu/edu-homework/user-answer-homework', 'id' => $model->id], ['class' => 'btn btn-secondary']);
                        }
                        else
                        {
                            return Html::a("Ожидает ответа", ['/edu/edu-homework/user-answer-homework', 'id' => $model->id], ['class' => 'btn btn-primary']);
                        }
                    }
                ],
                [
                    'attribute' => 'link',
                    'format'    => 'raw',
                    'value' => function (EduHomework $model) {
                        return Html::a("Просмотр", ['/edu/edu-homework/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                ]
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
