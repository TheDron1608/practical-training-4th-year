<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\edu\models\EduHomeworkUsers $model */
/** @var array $answerFiles */

?>

<div>

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

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'homework_teacher_comment')->textarea() ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'homework_grade')->radioList([
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ]) ?>
    </div>

    <div>
        <?= Html::submitButton(Yii::t('app', 'Send'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>