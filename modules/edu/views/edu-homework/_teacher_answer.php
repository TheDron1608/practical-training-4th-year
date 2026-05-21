<?php

use app\modules\edu\models\EduHomeworkUsers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\edu\models\EduHomeworkUsers $model */
/** @var array $answerFiles */

?>

<div>
    <?php if ($model->isAnswered): ?>
        <div class="card mb-3">
            <div class="card-content">

                <h5 class="filemanager-content__heading"><?= Yii::t('app', 'Файлы ответа') ?></h5>
                <hr>

                <div class="filemanager">
                    <div class="filemanager-content__quick">
                        <div class="filemanager-content__quick-wrapper" style="margin-top: 0px">
                            <?php
                                if (!empty($answerFiles))
                                {
                                    foreach ($answerFiles as $file)
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

        <div class="card mb-3">
            <div class="card-content">
                <h5><?= Yii::t('app', 'Комментарий ответа') ?></h5>
                <hr>

                <p>
                    <?= $model->homework_answer_comment ?>
                </p>
            </div>
        </div>
    <?php else: ?>
        <h3>Задание не прикреплено</h3>
    <?php endif ?>
            
    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!$model->isoverdued && $model->isAnswered): ?>
        <div class="row">
            <div class="col-4">
                <div class="mb-3">
                    <?= $form->field($model, 'homework_grade')->radioList([
                        5 => EduHomeworkUsers::GRADE_LABELS[5],
                        4 => EduHomeworkUsers::GRADE_LABELS[4],
                        3 => EduHomeworkUsers::GRADE_LABELS[3],
                        2 => EduHomeworkUsers::GRADE_LABELS[2],
                        null => "Без оценки"
                        ],
                        ['separator' => '<br>']
                        ) ?>
                </div>

                <?= $form->field($model, 'allow_overdue')->checkbox() ?>
            </div>

            <div class="col-8">
        
                <div class="mb-3">
                    <?= $form->field($model, 'homework_teacher_comment')->textarea() ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?= $form->field($model, 'allow_overdue')->checkbox() ?>
    <?php endif ?>

    <br>
    <div>
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => 'btn btn-success',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>