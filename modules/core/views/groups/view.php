<?php

use app\modules\core\models\Groups;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\modules\core\models\Groups $model */

$this->title = $model->group_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Группы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<div class="groups-view">

    <div class="card mb-3">
        <div class="card-content">

            <h4><?= Html::encode($this->title) ?></h4>
            <hr>

            <div class="icons-list card-content__icons mb-3">
                <div class="icon">
                    <?= Html::a('<i class="bi bi-pencil-square"></i>', ['update', 'id' => $model->id]) ?>
                </div>
                <div class="icon">
                    <?= Html::a('<i class="bi bi-person-plus"></i>', ['add-users', 'groupId' => $model->id]) ?>
                </div>
            </div>

            <div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td><?= Yii::t('app', 'Куратор') ?></td>
                            <td><?= $model->groupCurator->getUserFio() ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Специальность') ?></td>
                            <td>
                                <?php
                                    if (!empty($model->groupSpecialisation))
                                    {
                                        echo $model->groupSpecialisation->name;
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Название') ?></td>
                            <td><?= $model->group_title ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'О группе') ?></td>
                            <td><?= $model->group_about ?></td>
                        </tr>
                        <tr>
                            <td><?= Yii::t('app', 'Статус') ?></td>
                            <td><?= Groups::STATUS_TYPE[$model->status] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

   <div class="row">

       <?php if (!empty($model->groupsUsers)): ?>
           <div class="col-md-6">
               <div class="card">
                   <div class="card-content">
                       <div>
                           <?= Yii::t('app', 'В группе:') ?>
                       </div>
                       <hr>

                       <div class="list-group">
                           <?php
                           foreach ($model->groupsUsers as $user)
                           {
                               if ($model->group_curator_id != $user->id)
                               {
                                   echo "<a href=\"#\" class=\"list-group-item list-group-item-action\">{$user->getUserFio()}</a>";
                               }
                           }
                           ?>
                       </div>
                   </div>
               </div>
           </div>
       <?php endif; ?>

       <?php if (!empty($model->groupSubjects)): ?>
           <div class="col-md-6">
               <div class="card">
                   <div class="card-body">
                       <div>
                           <?= Yii::t('app', 'Предметы') ?>
                       </div>
                       <hr>

                       <div class="list-group">
                           <?php
                               foreach ($model->groupSubjects as $subject)
                               {
                                   echo "<a href=\"#\" class=\"list-group-item list-group-item-action\">{$subject->subject_title}</a>";
                               }
                           ?>
                       </div>
                   </div>
               </div>
           </div>
       <?php endif; ?>

   </div>

</div>
