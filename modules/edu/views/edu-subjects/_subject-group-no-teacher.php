<?php
use yii\helpers\Html;

/** @var app\modules\edu\models\EduSubjects $model */
/** @var bool $showTeacher */
?>

<div>
    <?= Html::a($model->group->group_title, ['/core/groups/view', 'id' => $model->group->id]) ?>
</div>