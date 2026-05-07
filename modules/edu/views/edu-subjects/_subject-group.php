<?php
use yii\helpers\Html;

/** @var app\modules\edu\models\EduSubjects $model */
?>

<div class="bg-light rounded-1 p-1 mb-1 justify-content-between">
    <p class="col-6">Группа: <?= Html::a($model->group->group_title, ['/core/groups/view', 'id' => $model->group->id]) ?></p>
    <p class="col-6">Учитель: <?= Html::a($model->teacher->getUserFio(), ['/core/user/view', 'id' => $model->teacher->id]) ?></p>
</div>