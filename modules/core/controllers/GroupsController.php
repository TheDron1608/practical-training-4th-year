<?php

namespace app\modules\core\controllers;

use app\modules\core\models\CoreFiles;
use app\modules\core\models\Groups;
use app\modules\core\models\GroupsSearch;
use app\modules\core\models\CuratorGroupsSearch;
use app\modules\core\models\GroupsUsers;
use app\modules\core\models\helpers\MessageHelper;
use app\modules\core\models\User;
use app\modules\edu\models\EduSubjectsGroups;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GroupsController implements the CRUD actions for Groups model.
 */
class GroupsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions'   => ['view'],
                            'allow'     => true,
                            'roles'     => ['@'],
                        ],
                        [
                            'actions'   => ['index', 'create', 'update', 'delete', 'add-users'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_ADMINISTRATOR, User::ROLE_CURATOR],
                        ],
                        [
                            'actions'   => ['curator-groups'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_CURATOR]
                        ]
                    ],
                ],
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
     * Lists all Groups models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel    = new GroupsSearch();
        $dataProvider   = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

        /**
     * Lists all Groups models.
     *
     * @return string
     */
    public function actionCuratorGroups()
    {
        $searchModel    = new CuratorGroupsSearch();
        $dataProvider   = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Groups model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Groups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Groups();

        if ($this->request->isPost)
        {
            $getUserId = Yii::$app->user->id;
            if ($model->setGroup($this->request->post(), $getUserId))
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Groups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->group_subjects = EduSubjectsGroups::getGroupSubjectIds($id);

        $getUserId = Yii::$app->user->id;

        if ( $this->request->isPost && $model->setGroup($this->request->post(), $getUserId, true) )
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /* ===== Добавить пользователей в группу. ===== */
    public function actionAddUsers(int $groupId)
    {
        $model = Groups::findOne($groupId);
        if ($model)
        {
            $dropUserIds = [$model->group_author_id, $model->group_curator_id];
            $model->group_users = GroupsUsers::getUsersInGroup($groupId, $dropUserIds);

            if ( $this->request->isPost && $model->load($this->request->post()) )
            {
                /* ===== Начало: Добавляем студентов по прикрепленному файлу. ===== */
                if ($model->group_users_file = UploadedFile::getInstance($model, 'group_users_file'))
                {
                    $fileName = uniqid(80) . '.txt';
                    $filePatch = Yii::getAlias('@app') . "/web/" . CoreFiles::DIR_TEMP_FILES . "/{$fileName}";
                    if ( $model->group_users_file->saveAs($filePatch) )
                    {
                        if ( GroupsUsers::addGroupUsersByFile($filePatch) )
                        {
                            Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
                            return $this->redirect(['view', 'id' => $groupId]);
                        }

                        Yii::$app->session->setFlash('success', Yii::t('app', 'Error!'));
                    }
                }
                /* ===== Конец: Добавляем студентов по прикрепленному файлу. ===== */

                /* ===== Начало: Добавляем пользователей в группу вручную через систему.. ===== */
                if (is_array($model->group_users))
                {
                    $arrUsersGroup = $model->getDefaultUsersInGroup();
                    if ( GroupsUsers::addGroupUsers($arrUsersGroup, $groupId) )
                    {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Успешно!'));
                        return $this->redirect(['view', 'id' => $groupId]);
                    }

                    Yii::$app->session->setFlash('danger', Yii::t('app', 'Error!'));
                }
                /* ===== Конец: Добавляем пользователей в группу вручную через систему.. ===== */
            }

            return $this->render('add_users', [
                'model' => $model,
            ]);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Groups model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete())
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
        }
        else
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Groups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Groups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Groups::findOne(['id' => $id])) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
