<?php

use app\modules\core\models\Groups;
use app\modules\core\models\GroupsUsers;
use app\modules\core\models\User;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\core\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'user_fio',
        'format'    => 'raw',
        'value' => function ($model) {
            return "{$model->user_f} {$model->user_i} {$model->user_o}";
        }
    ],
    'email:email',
    [
        'attribute' => 'status',
        'format'    => 'raw',
        'filter'    => User::getStatusTypeAll(),
        'value' => function ($model) {
            return User::getStatusTypeAll()[$model->status];
        }
    ],
    [
        'attribute' => 'role',
        'format'    => 'raw',
        'filter'    => array_combine(User::ROLE_ALL, User::translateRoles(User::ROLE_ALL)),
        'value' => function ($model) {
            return implode(', ', User::translateRoles(User::getUserRoles($model->id)));
        }
    ],
    [
        'attribute' => 'student_group',
        'format'    => 'raw',
        'filter'    => array_combine(Groups::getGroupList(), Groups::getGroupList()),
        'value' => function ($model) {
            $roles = GroupsUsers::getUserGroups($model->id);
            $studentRole = array_filter($roles, fn ($value) => $value['user_role'] == GroupsUsers::ROLE_USER);
            return array_key_exists(0, $studentRole) ? $studentRole[0]['group']['group_title'] : "-";
        }
    ],
    [
        'attribute' => 'date',
        'label'     => Yii::t('app', 'Создание / Редактирование'),
        'format'    => 'raw',
        'filter'    => false,
        'value' => function ($model) {
            return Yii::$app->formatter->asDatetime($model->created_at)
                . ' / ' .
                Yii::$app->formatter->asDatetime($model->updated_at);
        }
    ],
    'snils',
    [
        'class' => ActionColumn::class,
        'urlCreator' => function ($action, User $model, $key, $index, $column) {
            return Url::toRoute([$action, 'id' => $model->id]);
        },
        'template' => "{view}\n{update}\n{delete}"
    ],
];

?>
<div class="user-index">

    <p>
        <?= Html::a(Yii::t('app', 'Создать пользователя'), ['create'], [
            'class' => Yii::$app->params['btnSuccessClass'],
        ]) ?>
    </p>

    <?php Pjax::begin(['timeout' => false]); ?>

    <div>

        <div class="d-flex justify-content-end">
            <h4 class="m-1">Сохранить как таблицу excel</h4>
            <?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'showColumnSelector' => false,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_CSV => false
                ],
            ]); ?>
        </div>
        <hr>

        <div class="table-overflow">
            <?= GridView::widget([
                'dataProvider'  => $dataProvider,
                'filterModel'   => $searchModel,
                'columns'       => $columns,
            ]); ?>
        </div>

    </div>

    <?php Pjax::end(); ?>

</div>