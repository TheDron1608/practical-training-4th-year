<?php

namespace app\modules\filehub\controllers;

use app\modules\core\models\CoreFiles;
use app\modules\core\models\CoreFilesSearch;
use app\modules\core\models\User;
use app\modules\filehub\models\FilehubFolders;
use app\modules\filehub\models\FilehubFoldersSearch;
use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Default controller for the `filehub` module
 */
class DefaultController extends Controller
{
    /* ===== Общий список файлов и папок. ===== */
    public function actionIndex()
    {
        /* ===== Начало: Получить папки. ===== */
        $filehubFoldersSearchModel = new FilehubFoldersSearch();
        $filehubFoldersSearchModel->is_parent_null = 1;
        $filehubFoldersSearchModel->status = FilehubFolders::STATUS_ACTIVE;
        $filehubFoldersSearchModel->folder_code = FilehubFolders::CODE_COMMON;

        $filehubFoldersDataProvider = $filehubFoldersSearchModel->search(Yii::$app->request->queryParams);
        $filehubFoldersDataProvider->pagination->pageSize = 50;
        /* ===== Конец: Получить папки. ===== */

        /* ===== Начало: Получить файлы. ===== */
        $coreFilesSearchModel = new CoreFilesSearch();
        $coreFilesSearchModel->file_folder_id = null;
        $coreFilesSearchModel->file_code = CoreFiles::CODE_FILEHUB;

        $coreFilesDataProvider = $coreFilesSearchModel->search(Yii::$app->request->queryParams);
        /* ===== Конец: Получить файлы. ===== */

        return $this->render('index', [
            'coreFilesSearchModel'          => $coreFilesSearchModel,
            'coreFilesDataProvider'         => $coreFilesDataProvider,
            'filehubFoldersSearchModel'     => $filehubFoldersSearchModel,
            'filehubFoldersDataProvider'    => $filehubFoldersDataProvider,
        ]);
    }

    /* ===== Список моих файлов и папок. ===== */
    public function actionMy()
    {
        $getUserId = Yii::$app->user->id;

        /* ===== Начало: Получить папки. ===== */
        $filehubFoldersSearchModel = new FilehubFoldersSearch();
        $filehubFoldersSearchModel->folder_owner_id = $getUserId;
        $filehubFoldersSearchModel->folder_code = FilehubFolders::CODE_MY;
        $filehubFoldersSearchModel->is_parent_null = 1;

        $filehubFoldersDataProvider = $filehubFoldersSearchModel->search(Yii::$app->request->queryParams);
        $filehubFoldersDataProvider->pagination->pageSize = 50;
        /* ===== Конец: Получить папки. ===== */

        /* ===== Начало: Получить файлы. ===== */
        $coreFilesSearchModel = new CoreFilesSearch();
        $coreFilesSearchModel->file_user_id = $getUserId;
        $coreFilesSearchModel->file_folder_id = null;

        $coreFilesDataProvider = $coreFilesSearchModel->search(Yii::$app->request->queryParams);
        /* ===== Конец: Получить файлы. ===== */

        return $this->render('index', [
            'coreFilesSearchModel'          => $coreFilesSearchModel,
            'coreFilesDataProvider'         => $coreFilesDataProvider,
            'filehubFoldersSearchModel'     => $filehubFoldersSearchModel,
            'filehubFoldersDataProvider'    => $filehubFoldersDataProvider,
        ]);
    }

    /* ===== Загрузка файлов в файлхаб. ===== */
    public function actionUploadFiles(?bool $referrer = false, ?int $folderId = null, ?bool $isMy = false)
    {
        $model = DynamicModel::validateData(['upload_files', 'folder_id'], [
            [['upload_files'], 'required'],
            [['folder_id'], 'integer'],
            ['upload_files', 'file', 'extensions' => 'jpg, jpeg, gif, png, pdf, docx, doc, csv, xls, xlsx, txt',
                'maxFiles' => 5, 'maxSize' => 50*1024*1024, 'skipOnEmpty' => true,
                'checkExtensionByMimeType' => false],
        ]);

        $getUserId = Yii::$app->user->id;
        $isAdministrationSite = User::isAdministrationSite($getUserId, null, true);

        $getFolders = FilehubFolders::getFolders($getUserId);

        if ($this->request->isPost)
        {
            if ($model->load($this->request->post()))
            {
                if ( $model->upload_files = UploadedFile::getInstances($model, 'upload_files') )
                {
                    if ($isMy)
                    {
                        $code = CoreFiles::CODE_FILEHUB_MY;
                    }
                    else
                    {
                        $code = CoreFiles::CODE_FILEHUB;
                    }

                    $uploadFolderId = $folderId ?? $model->folder_id;

                    $fileIds = CoreFiles::multipleUploadFiles($model->upload_files, $getUserId, CoreFiles::DIR_UPLOADED_FILES, $code, null, !empty($uploadFolderId) ? $uploadFolderId : null);

                    if (!empty($fileIds))
                    {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));

                        if ($referrer)
                        {
                            return $this->redirect($this->request->referrer);
                        }

                        if ($isMy)
                        {
                            return $this->redirect(['my']);
                        }

                        return $this->redirect(['index']);
                    }

                    Yii::$app->session->setFlash('danger', Yii::t('app', 'Error!'));
                    if ($referrer)
                    {
                        return $this->redirect($this->request->referrer);
                    }
                }
            }
        }

        if ($referrer && isset($folderId))
        {
            return $this->renderAjax('upload_files', [
                'model'                 => $model,
                'getFolders'            => $getFolders,
                'isAdministrationSite'  => $isAdministrationSite,
                'folderId'              => $folderId,
            ]);
        }

        return $this->render('upload_files', [
            'model'                 => $model,
            'getFolders'            => $getFolders,
            'isAdministrationSite'  => $isAdministrationSite,
        ]);
    }

    public function actionDownloadFile($id)
    {
        $file = CoreFiles::getFile($id);

        if ($file !== null)
        {
            return Yii::$app->response->sendFile(Yii::getAlias('@app/web') . $file['file_patch'], $file['file_title']);
        }
        else 
        {
            echo "file not found";
        }
    }
}