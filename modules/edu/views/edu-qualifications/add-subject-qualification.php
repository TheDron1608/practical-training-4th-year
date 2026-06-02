<?php

/** @var app\modules\edu\models\EduQualifications $model */
/** @var yii\widgets\ActiveForm $form */

use unclead\multipleinput\MultipleInput;
use kartik\select2\Select2;
use app\modules\edu\models\EduQualifications;
use app\modules\core\models\Groups;
use app\modules\core\models\User;
use app\modules\edu\models\SubjectQualification;
use kartik\form\ActiveForm;

?>

<div class="edu-qualifications-update">

    <div class="card">
        <div class="card-content">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'temp_qualification_input')->widget(MultipleInput::class, [
                'allowEmptyList'    => true,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_HEADER,
                'columns' => [
                    [
                        'name'  => 'qualification_id',
                        'title' => Yii::t('app', 'Квалификация'),
                        'type'  => Select2::class,
                        'options' => [
                            'data' => EduQualifications::getEduQualificationsList()
                        ]
                    ],

                    [
                        'name'  => 'code',
                        'title' => Yii::t('app', 'Индекс'),
                        'type'  => 'textInput'
                    ],

                    [
                        'name'  => 'hours',
                        'title' => Yii::t('app', 'Часы'),
                        'type'  => 'textInput',
                        'options' => [
                            'type' => 'number',
                            'min' => 1
                        ]
                    ],
                ]
            ]) ?>

            <?= $form->field($model, 'temp_group_input')->widget(MultipleInput::class, [
                'allowEmptyList'    => true,
                'enableGuessTitle'  => true,
                'addButtonPosition' => MultipleInput::POS_HEADER,
                'columns' => [
                    [
                        'name'  => 'group_id',
                        'title' => Yii::t('app', 'Группа'),
                        'type'  => Select2::class,
                        'options' => [
                            'data' => Groups::getGroupList()
                        ]
                    ],

                    [
                        'name'  => 'subject_qualification_id',
                        'title' => Yii::t('app', 'Квалификация'),
                        'type'  => Select2::class,
                        'options' => [
                            'data' => SubjectQualification::getSubjectQualificationsList($model->id)
                        ]
                    ],

                    [
                        'name'  => 'teacher_id',
                        'title' => Yii::t('app', 'Учитель'),
                        'type'  => Select2::class,
                        'options' => [
                            'data' => User::getUserList(null, User::ROLE_TEACHER)
                        ]
                    ],
                ]
            ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>