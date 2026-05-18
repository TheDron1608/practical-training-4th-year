<?php

use app\modules\core\models\helpers\MessageHelper;
use app\modules\edu\models\EduHomework;
use app\modules\edu\models\EduHomeworkUsers;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduHomework $model */
/** @var \yii\data\ActiveDataProvider|false $usersHomeworkDataProvider */
/** @var array $homeworkFiles */
/** @var array $getUserHomework */
/** @var array $getUserHomeworkAnswerFiles */
/** @var int $getUserId */
/** @var bool $isTeacher */

$this->title = $model->homework_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ДЗ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="edu-homework-view">

    <div class="card mb-3">
        <div class="card-content">

            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <?php if ($model->isHomeworkTeacher($getUserId)): ?>
                <div class="icons-list card-content__icons mb-3">
                    <div class="icon">
                        <?= Html::a('<i class="bi bi-pencil-square"></i>', ['update', 'id' => $model->id]) ?>
                    </div>
<!--                    <div class="icon">-->
<!--                        --><?//= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
//                            'data' => [
//                                'confirm' => MessageHelper::messages()[MessageHelper::KEY_CONFIRM],
//                                'method' => 'post',
//                            ],
//                        ]) ?>
<!--                    </div>-->
                </div>
            <?php endif; ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'homework_teacher_id',
                        'format'    => 'raw',
                        'value' => function (EduHomework $model) {
                            return $model->homeworkTeacher->getUserFio();
                        }
                    ],
                    [
                        'attribute' => 'homework_group_id',
                        'format'    => 'raw',
                        'value' => function (EduHomework $model) {
                            return Html::a($model->homeworkGroup->group_title, [Url::to('/core/groups/view'), 'id' => $model->homework_group_id]);
                        }
                    ],
                    [
                        'attribute' => 'homework_subject_id',
                        'format'    => 'raw',
                        'value' => function (EduHomework $model) {
                            return $model->homeworkSubject->subject_title;
                        }
                    ],
                    'homework_deadline',
                    [
                        'attribute' => 'status',
                        'label' => Yii::t('app', 'Статус'),
                        'format'    => 'raw',
                        'value' => function (EduHomework $model) {
                            return EduHomework::getStatusType()[$model->status];
                        }
                    ]
                ],
            ]) ?>

            <?php if (!$isTeacher): ?>
                <hr>
                <div>
                    <div>
                        <?= Yii::t('app', '<strong>Оценка</strong> : {grade}', [
                            'grade' => $getUserHomework['homework_grade'] ?? '---',
                        ]) ?>
                    </div>
                    <div>
                        <?= Yii::t('app', '<strong>Комментарий поставщика</strong> : {comment}', [
                            'comment' => $getUserHomework['homework_teacher_comment'] ?? '---',
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <div class="card-footer">
            <?= Yii::t('app', 'Дата создания: {created_at}', [
                'created_at' => Yii::$app->formatter->asDatetime($model->created_at),
            ]) ?>
        </div>
    </div>

    <?php if (!empty($homeworkFiles)): ?>
        <div class="card mb-3">
            <div class="card-content">

                <h5 class="filemanager-content__heading"><?= Yii::t('app', 'Файлы') ?></h5>
                <hr>

                <div class="filemanager">
                    <div class="filemanager-content__quick">
                        <div class="filemanager-content__quick-wrapper" style="margin-top: 0px">
                            <?php
                                if (!empty($homeworkFiles))
                                {
                                    foreach ($homeworkFiles as $file)
                                    {
                                        echo $this->renderFile(Yii::getAlias('@app') . '/modules/filehub/components/views/_file_card.php', [
                                            'model' => $file
                                        ]);
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php endif ?>

    <?php if (!empty($model->homework_content)): ?>
        <div class="card">
            <div class="card-content">
                <p>
                    <?= $model->homework_content ?>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <hr>
    <div>
        <?php
            if ($isTeacher && $usersHomeworkDataProvider)
            {
                echo GridView::widget([
                    'dataProvider' => $usersHomeworkDataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'homework_user_id',
                            'format'    => 'raw',
                            'value' => function (EduHomeworkUsers $model) {
                                return $model->homeworkUser->getUserFio();
                            }
                        ],

                        'homework_grade',

                        [
                            'label'     => Yii::t('app', 'Ответил ли студент'),
                            'format'    => 'raw',
                            'value' => function (EduHomeworkUsers $model) {
                                return !empty($model->homework_answer_ids) || !empty($model->homework_answer_comment)
                                    ? Yii::t('app', 'Yes')
                                    : Yii::t('app', '---');
                            }
                        ],

                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app', 'Статус'),
                            'format'    => 'raw',
                            'value' => function (EduHomeworkUsers $model) {
                                return EduHomeworkUsers::getStatusType()[$model->status];
                            }
                        ],

                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => function ($action, EduHomeworkUsers $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => "{view}",
                            'buttons' => [
                                'view' => function ($url, EduHomeworkUsers $model)  {
                                    if ($model->status == EduHomeworkUsers::STATUS_WAITING_FOR_VERIFICATION)
                                    {
                                        return Html::a('<i class="bi bi-clipboard-check"></i>', false, [
                                            'data-bs-toggle'    => 'modal',
                                            'data-bs-target'    => '#my-modal',
                                            'id'                => 'upload-modal-button',
                                            'value'             => Url::to([ '/edu/edu-homework/teacher-answer', 'homeworkId' => $model->homework_id, 'userId' => $model->homework_user_id ]),
                                        ]);
                                    }
                                }
                            ],
                        ],
                    ],
                ]);
            }
            else if ( !empty($getUserHomework) )
            {
                if ( $getUserHomework['status'] == EduHomeworkUsers::STATUS_WAITING_FOR_AN_ANSWER )
                {
                    echo Html::a(Yii::t('app', 'Прикрепить ответ'), false, [
                        'class'             => Yii::$app->params['btnSuccessClass'],
                        'data-bs-toggle'    => 'modal',
                        'data-bs-target'    => '#my-modal',
                        'id'                => 'upload-modal-button',
                        'value'             => Url::to([ '/edu/edu-homework/user-answer-homework', 'id' => $model->id ]),
                    ]);
                }
                else
                {
                    echo $this->render('_answer', ['model' => $getUserHomework, 'answerFiles' => $getUserHomeworkAnswerFiles]);
                }
            }
        ?>
    </div>

</div>