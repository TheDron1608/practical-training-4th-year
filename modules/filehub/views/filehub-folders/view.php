<?php

use app\modules\core\models\helpers\MessageHelper as MessageHelperAlias;
use app\modules\filehub\models\FilehubFolders;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $coreFilesDataProvider */
/** @var \yii\data\ActiveDataProvider $filehubFoldersDataProvider */
/** @var app\modules\filehub\models\FilehubFolders $model */
/** @var int $getUserId */

$this->title = $model->folder_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Файловый хаб'), 'url' => [Url::to('/filehub')]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="filehub-folders-view">

    <div class="card">
        <div class="card-body">

            <h4><?= Html::encode($this->title) ?></h4>
            <hr>


            <div class="icons-list card-content__icons mb-3">
                <?php if (isset($model->folder_parent_id)): ?>
                    <div class="icon">
                        <?= Html::a('<i class="bi bi-folder-symlink"></i>', ['view', 'id' => $model->folder_parent_id]) ?>
                    </div>
                <?php endif; ?>
                <?php if ($model->isUserFolderOwner($getUserId, false)): ?>
                    <div class="icon">
                        <?= Html::a('<i class="bi bi-pencil-square"></i>', ['update', 'id' => $model->id]) ?>
                    </div>
                    <div class="icon">
                        <?= Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => MessageHelperAlias::messages()[MessageHelperAlias::KEY_CONFIRM],
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'folder_parent_id',
                        'label'     => Yii::t('app', 'Папка'),
                        'format'    => 'raw',
                        'value' => function (FilehubFolders $model) {
                            if (!empty($model->folder_parent_id))
                            {
                                return Html::a('<i class="bi bi-folder-symlink"></i>', ['view', 'id' => $model->folder_parent_id]) . ' ' . Html::a($model->folderParent->folder_title, ['view', 'id' => $model->folder_parent_id]);
                            }
                        }
                    ],
                    'folder_title',
                    'folder_about',
//                    'status',
//                    [
//                        'attribute' => 'status',
//                        'format'    => 'raw',
//                        'value' => function (FilehubFolders $model) {
//                            return FilehubFolders::
//                        }
//                    ],
                    [
                        'attribute' => 'created_at',
                        'format'    => 'raw',
                        'value' => function (FilehubFolders $model) {
                            return Yii::$app->formatter->asDatetime($model->created_at);
                        }
                    ],
                ],
            ]) ?>

        </div>
    </div>

    <div class="filemanager">
        <div class="filemanager-wrapper">

            <div class="filemanager-sidebar">

                <div class="filemanager-sidebar__actions">

                    <?php if ($model->isUserFolderOwner($getUserId, false)): ?>
                        <?= Html::a(Yii::t('app', 'Создать папку'), ['create', 'id' => $model->id], [
                            'class'     => Yii::$app->params['btnSuccessClass'] . ' filemanager-sidebar__actions-btn',
                            'data-pjax' => 0,
                        ]) ?>
                        <hr>
                    <?php endif; ?>

                    <div>
                        <?= $this->renderFile( Yii::getAlias('@app') . '/modules/filehub/components/views/_filehub_folders_list.php', [
                            'dataProvider'  => $filehubFoldersDataProvider,
                        ]) ?>
                    </div>

                </div>

            </div>

            <div class="filemanager-content">

                <?php if ($model->isUserFolderOwner($getUserId, false)): ?>
                    <div class="filemanager-content__header">
                        <div class="filemanager-content__header-buttons">
                            <?= Html::a('
                                    <div class="button button__icon button__gray filemanager-content__header-button">
                                        <i class="bi bi-upload"></i>
                                    </div>
                                ', false, [
                                'data-bs-toggle'    => 'modal',
                                'data-bs-target'    => '#my-modal',
                                'id'                => 'upload-modal-button',
                                'value'             => Url::to(['/filehub/default/upload-files', 'referrer' => true, 'folderId' => $model->id]),
                            ]) ?>
                        </div>
                    </div>
                <?php endif; ?>
                <h5 class="filemanager-content__heading"><?= Yii::t('app', 'Файлы') ?></h5>
                <div class="filemanager-content__quick">
                    <div class="filemanager-content__quick-wrapper">
                        <?= $this->renderFile( Yii::getAlias('@app') . '/modules/filehub/components/views/_filehub_files_list.php', [
                            'dataProvider'  => $coreFilesDataProvider,
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?php

Modal::begin([
    'id'   => 'my-modal',
    'size' => 'modal-lg'
]);

Pjax::begin(['id' => 'my-modal-content', 'timeout' => FALSE, 'enablePushState' => FALSE,]);

Pjax::end();

Modal::end();

$js = <<< JS
    $("document").ready(function () {
        
        $(document).on('click', '#upload-modal-button', function(){
            //if ($('#my-modal').data('bs.modal').isShown) {
                $('#my-modal').find('#my-modal-content').load($(this).attr('value'), $(this));
            //}
            
            $("#my-modal").on("pjax:end", function(data) {
                $.pjax.reload({container:"#opp-modules"});  
            });   
        });
        
    });
JS;

$this->registerJs($js,View::POS_READY, null);