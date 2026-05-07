<?php

namespace app\modules\edu\controllers;

use app\modules\core\models\User;
use app\modules\edu\models\EduSubjects;
use app\modules\edu\models\EduSubjectsSearch;
use app\modules\edu\models\EduMySubjectsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EduSubjectsController implements the CRUD actions for EduSubjects model.
 */
class EduSubjectsController extends Controller
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
                            'actions'   => ['index'],
                            'allow'     => true,
                            'roles'     => ['@'],
                        ],
                        [
                            'actions'   => ['my-subjects'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_TEACHER],
                        ],
                        [
                            'actions'   => ['view', 'create', 'update', 'delete'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_ADMINISTRATOR, User::ROLE_CURATOR, User::ROLE_TEACHER],
                        ],
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
     * Lists all EduSubjects models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $getUserId              = Yii::$app->user->id;
        $isAdministrationSite   = User::isAdministrationSite($getUserId);

        $searchModel = new EduSubjectsSearch();

        if (!$isAdministrationSite)
        {
            $searchModel->status = EduSubjects::STATUS_ACTIVE;
        }

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'getUserId'             => $getUserId,
            'isAdministrationSite'  => $isAdministrationSite,
        ]);
    }

    public function actionMySubjects()
    {
        $getUserId = Yii::$app->user->id;

        $searchModel = new EduSubjectsSearch();
        $searchModel->my_subjects_only = true;

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('mySubjects', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'getUserId'             => $getUserId,
        ]);
    }

    /**
     * Displays a single EduSubjects model.
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
     * Creates a new EduSubjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EduSubjects();

        if ($this->request->isPost)
        {
            if ($model->load($this->request->post()) && $model->save())
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
     * Updates an existing EduSubjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EduSubjects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EduSubjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EduSubjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EduSubjects::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
