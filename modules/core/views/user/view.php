<?php

use app\modules\core\models\helpers\MessageHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\core\models\User $model */
/** @var array $userGroups */

$this->title = $model->getUserFio();
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="user-view">

    <div class="profile mb-3">
        <div class="profile-header">
            <div class="profile-header__bg"></div>
            <div class="profile-header__content">
                <div class="avatar avatar__big avatar__round avatar__border">
                    <?php
                        if (isset($model->avatar_id))
                        {
                            $img = $model->userAvatar->file_patch;
                        }
                        else
                        {
                            $img = Yii::getAlias('@web') . "/img/no_avatar.png";
                        }

                        echo Html::img($img, [
                            'class' => 'avatar-img',
                        ]);
                    ?>
                </div>
                <h5 class="profile-header__content-title"><?= Html::encode($this->title) ?></h5>
            </div>
        </div>
        <div class="tabs profile-tabs">
            <div class="tabs-tab tabs-tab__active"><?= Yii::t('app', 'Профиль') ?></div>
            <div class="tabs-tab">
                <?= Html::a(Yii::t('app', 'Выйти'), ['logout'], [
                    'data' => [
                        'method'    => 'POST',
                        'confirm'   => MessageHelper::messages()[MessageHelper::KEY_CONFIRM],
                    ]
                ]) ?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6">
            <?= $this->renderFile(Yii::getAlias('@app') . '/modules/core/components/views/cards/_card_user_about.php', [
                'model' => $model
            ]) ?>
        </div>

    </div>

</div>