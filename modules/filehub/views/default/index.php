<?php

use app\modules\core\models\CoreFiles;
use app\modules\filehub\models\FilehubFolders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $coreFilesDataProvider */
/** @var \yii\data\ActiveDataProvider $filehubFoldersDataProvider */
/** @var \app\modules\core\models\CoreFilesSearch $coreFilesSearchModel */

if ( Yii::$app->controller->action->id == 'my' )
{
    $uploadFileUrlParams = ['upload-files', 'isMy' => true];
}
else
{
    $uploadFileUrlParams = ['upload-files'];
}
?>

<div class="filehub-default-index">

    <div class="card mb-3">
        <div class="card-content">
            <?php
                if ( Yii::$app->controller->action->id == 'my' )
                {
                    echo Yii::t('app', 'Мой хаб');
                }
                else
                {
                    echo Yii::t('app', 'Общий хаб');
                }
            ?>
        </div>
    </div>

    <?php Pjax::begin(['timeout' => false]); ?>

        <div class="card mb-3">
            <div class="card-body">
                <?= $this->render('_filter_core_files', [
                    'model' => $coreFilesSearchModel,
                ]) ?>
            </div>
        </div>

        <div class="filemanager">
            <div class="filemanager-wrapper">

                <div class="filemanager-sidebar">

                    <div class="filemanager-sidebar__actions">

                        <?= Html::a(Yii::t('app', 'Создать папку'), [Url::to('/filehub/filehub-folders/create')], [
                            'class'     => Yii::$app->params['btnSuccessClass'] . ' filemanager-sidebar__actions-btn',
                            'data-pjax' => 0,
                        ]) ?>
                        <hr>

                        <div>
                            <?= $this->renderFile( Yii::getAlias('@app') . '/modules/filehub/components/views/_filehub_folders_list.php', [
                                'dataProvider'  => $filehubFoldersDataProvider,
                            ]) ?>
                        </div>

                    </div>

                </div>

                <div class="filemanager-content">

                    <div class="filemanager-content__header">
                        <div class="filemanager-content__header-buttons">
                            <?= Html::a('
                                <div class="button button__icon button__gray filemanager-content__header-button">
                                    <i class="bi bi-upload"></i>
                                </div>
                            ', $uploadFileUrlParams, [
                                'data-pjax' => 0,
                            ]) ?>
                        </div>
                    </div>
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

    <?php Pjax::end(); ?>

</div>