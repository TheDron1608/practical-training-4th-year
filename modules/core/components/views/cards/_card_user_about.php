<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\core\models\User;

/** @var \app\modules\core\models\User $model */
/** @var array $userGroups */

?>

<div class="card card__only-info">
    <div class="card-content">
        <h5 class="card-content__heading"><?= Yii::t('app', 'О нас') ?></h5>
    </div>
    <div class="card-content">
        <p class="card-content__dscrp">
            <?= !empty($model->about) ? $model->about : '...' ?>
        </p>
    </div>
    <div class="card-content">
        <div>
            <table class="table">
                <tbody>
                    <tr>
                        <td><?= Yii::t('app', 'ФИО') ?></td>
                        <td><?= Html::encode($this->title) ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Почта') ?></td>
                        <td><a href="mailto:<?= $model->email ?>"><?= $model->email ?></a></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Дата регистрации') ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                    </tr>
                    <?php if (
                        $model->id == Yii::$app->user->id || 
                        User::isUserRole(Yii::$app->user->id, User::ROLE_ADMINISTRATOR) ||
                        User::isUserRole(Yii::$app->user->id, User::ROLE_CURATOR)
                        ): ?>
                        <tr>
                            <td><?= Yii::t('app', 'Снилс') ?></td>
                            <td><?= html::encode($model->snils) ?></td>
                        </tr>
                    <?php endif ?>
                    <?php if (User::isUserRole($model->id, User::ROLE_USER) && $model->studentGroup != null): ?>
                        <tr>
                            <td><?= Yii::t('app', 'Группа') ?></td>
                            <td><?= Html::a($model->studentGroup->group_title, [Url::to('/core/groups/view'), 'id' => $model->student_group_id]) ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="icons-list card-content__icons">
            <div class="icon">
                <?= Html::a('<i class="bi bi-pencil-square"></i>', ['update', 'id' => $model->id]) ?>
            </div>
        </div>
    </div>
</div>