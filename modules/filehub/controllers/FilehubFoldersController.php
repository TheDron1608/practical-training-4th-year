<?php

namespace app\modules\filehub\controllers;

use app\modules\core\models\CoreFiles;
use app\modules\core\models\CoreFilesSearch;
use app\modules\core\models\helpers\MessageHelper;
use app\modules\core\models\User;
use app\modules\filehub\models\FilehubFolders;
use app\modules\filehub\models\FilehubFoldersSearch;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FilehubFoldersController implements the CRUD actions for FilehubFolders model.
 */
class FilehubFoldersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Displays a single FilehubFolders model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $getUserId = Yii::$app->user->id;
        $model = $this->findModel($id);

        /* ===== Начало: Получение файлов в папке. ===== */
        $coreFilesSearchModel = new CoreFilesSearch();
        $coreFilesSearchModel->file_folder_id = $id;
        $coreFilesSearchModel->status = CoreFiles::STATUS_ACTIVE;

        $coreFilesDataProvider = $coreFilesSearchModel->search($this->request->queryParams);
        $coreFilesDataProvider->pagination->pageSize = 50;
        /* ===== Конец: Получение файлов в папке. ===== */

        /* ===== Начало: Получить папки, которые находятся в папке. ===== */
        $filehubFoldersSearchModel = new FilehubFoldersSearch();
        $filehubFoldersSearchModel->folder_parent_id = $id;
        $filehubFoldersSearchModel->status = FilehubFolders::STATUS_ACTIVE;

        $filehubFoldersDataProvider = $filehubFoldersSearchModel->search(Yii::$app->request->queryParams);
        $filehubFoldersDataProvider->pagination->pageSize = 50;
        /* ===== Конец: Получить папки, которые находятся в папке. ===== */

        return $this->render('view', [
            'getUserId'                     => $getUserId,
            'model'                         => $model,
            'coreFilesSearchModel'          => $coreFilesSearchModel,
            'coreFilesDataProvider'         => $coreFilesDataProvider,
            'filehubFoldersDataProvider'    => $filehubFoldersDataProvider,
        ]);
    }

    /**
     * Creates a new FilehubFolders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate(?int $id = null)
    {
        $getUserId = Yii::$app->user->id;
        $model = new FilehubFolders();

        if (isset($id))
        {
            $parentFolder = self::findModel($id);
            $isUserFolderOwner = $parentFolder->isUserFolderOwner($getUserId);
        }

        $isAdministrationSite = User::isAdministrationSite($getUserId, null);

        if ($this->request->isPost)
        {
            if ( $model->setFolder($this->request->post(), $getUserId, $id, $isAdministrationSite) )
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model'                 => $model,
            'isAdministrationSite'  => $isAdministrationSite,
        ]);
    }

    /**
     * Updates an existing FilehubFolders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $getUserId = Yii::$app->user->id;

        $model = $this->findModel($id);
        $isUserFolderOwner = $model->isUserFolderOwner($getUserId);

        $isAdministrationSite = User::isAdministrationSite($getUserId, null);

        if ($this->request->isPost)
        {
            if ( $model->setFolder($this->request->post(), $getUserId, null, $isAdministrationSite, true) )
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model'                 => $model,
            'isAdministrationSite'  => $isAdministrationSite
        ]);
    }

    /**
     * Deletes an existing FilehubFolders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $getUserId = Yii::$app->user->id;

        $model = $this->findModel($id);
        if ($model->deleteFolder($getUserId))
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
        }
        else
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        }

        return $this->redirect(Url::to('/filehub/my'));
    }

    /**
     * Finds the FilehubFolders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return FilehubFolders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FilehubFolders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
