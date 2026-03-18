<?php

/** @var \yii\web\View $this */

use yii\helpers\Html;

$links = [
    [
        'title' => Yii::t('app', 'Управление пользователями'),
        'href'  => '/core/user/index',
    ],

    [
        'title' => Yii::t('app', 'Управление группами'),
        'href'  => '/core/groups/index',
    ],

    [
        'title' => Yii::t('app', 'Управление квалицикациями'),
        'href'  => '/edu/edu-qualifications/index',
    ],

    [
        'title' => Yii::t('app', 'Управление предметами'),
        'href'  => '/edu/edu-subjects/index',
    ],

    [
        'title' => Yii::t('app', 'Управление специальностями'),
        'href'  => '/edu/edu-specialisations/index',
    ],
];

$this->title = Yii::t('app', 'Админ панель');

?>

<div class="card">
    <div class="card-content">

        <h4><?= Html::encode($this->title) ?></h4>
        <hr>

        <?= $this->renderFile( Yii::getAlias('@app') . '/components/control_panel/views/_buttons.php', [
            'links' => $links
        ] ) ?>

    </div>
</div>