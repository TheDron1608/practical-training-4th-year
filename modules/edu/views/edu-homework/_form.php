<?php

use app\modules\core\models\Groups;
use app\modules\core\models\User;
use app\modules\edu\models\EduSubjects;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\edu\models\EduHomework $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="edu-homework-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'homework_group_id')->widget(Select2::class, [
                'data'      => Groups::getGroupList(),
                'options'   => [
                    'id'        => 'group-input',
                    'placeholder' => '...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="col-md-6 mb-3">
            <?= $form->field($model, 'homework_subject_id')->widget(Select2::class, [
                'data'      => Yii::$app->user->identity->teacherSubjectsList,
                'options'   => [
                    'id'        => 'subject-input',
                    'placeholder' => '...',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'homework_title')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="mb-3">
            <?= $form->field($model, 'homework_content')->textarea(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12 mb-3">
            <?= $form->field($model, 'homework_files')->widget(FileInput::class, [
                'options' => [
                    'multiple'=>true
                ],
                'pluginOptions' => [
                    'showPreview'   => false,
                    'showCaption'   => true,
                    'showRemove'    => false,
                    'showUpload'    => false
                ]
            ])->label(Yii::t('app', 'Файлы')) ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'homework_deadline')->widget(DatePicker::class, ['dateFormat' => 'yyyy-MM-dd']) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    const groupInput = document.getElementById("group-input");
    const subjectInput = document.getElementById("subject-input");

    let groupsSubjects = {};
    let groupOptions;

    <?php foreach (Groups::find()->all() as $group): ?>
        groupOptions = [];
        <?php foreach (Yii::$app->user->identity->teacherSubjects as $subject): ?>
            <?php if ($subject->getSubjectIsInGroup($group)): ?>
                groupOptions.push(new Option('<?= $subject->subject_title ?>', '<?=$subject->id ?>'));
            <?php endif ?>
        <?php endforeach ?>
        groupsSubjects['<?= $group->id ?>'] = groupOptions;
    <?php endforeach ?>

    groupInput.onchange = (event) => {
        updateSubjectInput(event.target.value);
    };

    updateSubjectInput(groupInput.value);
    
    function updateSubjectInput(value)
    {
        subjectInput.innerHTML = ''; 
        
        if (value)
        {
            groupsSubjects[value].forEach(elem => {
                subjectInput.add(elem);
            });
        }
    }
</script>