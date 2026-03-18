<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\core\models\User $model */

$this->title = Yii::t('app', 'Создать пользователя');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="card">
        <div class="card-content">
            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <?= $this->render('_form', [
                'model'     => $model,
                'isCreate'  => true,
            ]) ?>
        </div>
    </div>

</div>