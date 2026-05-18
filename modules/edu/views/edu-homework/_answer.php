<?php

use yii\helpers\Html;
use app\modules\edu\models\EduHomeworkUsers;
use app\modules\core\models\helpers\MessageHelper;
use yii\helpers\Url;

/** @var app\modules\edu\models\EduHomeworkUsers $model */
/** @var array $answerFiles */
/** @var bool $allowEdit */

?>


<div class="card">
    <div class="card-content">
        <h5 class="filemanager-content__heading">Ответ</h5>

        <hr>

        <div>
            <?= Html::encode($model->homework_answer_comment) ?>
        </div>

        <div class="filemanager">
            <div class="filemanager-content__quick">
                <div class="filemanager-content__quick-wrapper" style="margin-top: 0px">
                    <?php foreach ($answerFiles as $file): ?>
                        <?= $this->renderFile(Yii::getAlias('@app') . '/modules/filehub/components/views/_file_card.php', [
                            'model' => $file
                        ]) 
                        ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <hr>

        <?php if ($model['status'] == EduHomeworkUsers::STATUS_WAITING_FOR_VERIFICATION && isset($allowEdit) && $allowEdit): ?>
            <div class='mt-3 d-flex'>
                <?= Html::a('
                    <div class="button button__icon button__gray filemanager-content__header-button m-1">
                        <i class="bi bi-pencil"></i>
                    </div>
                    ', Url::to([ '/edu/edu-homework/user-answer-homework', 'id' => $model['homework_id'] ])
                ) ?>

                <?= Html::a('
                    <div class="button button__icon button__gray filemanager-content__header-button m-1">
                        <i class="bi bi-trash"></i>
                    </div>
                    ', [ Url::to('/edu/edu-homework/drop-user-answer-homework'), 'userAnswerHomeworkId' => $model['id'] ], [
        
                    'data' => [
                        'method'    => 'POST',
                        'confirm'   => MessageHelper::messages()[MessageHelper::KEY_CONFIRM],
                    ]
                ]);
                ?>
            </div>
        <?php endif ?>
    </div>
</div>
