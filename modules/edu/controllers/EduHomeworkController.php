<?php

namespace app\modules\edu\controllers;

use app\modules\core\models\CoreFiles;
use app\modules\core\models\helpers\MessageHelper;
use app\modules\core\models\User;
use app\modules\edu\models\EduHomework;
use app\modules\edu\models\EduHomeworkSearch;
use app\modules\edu\models\EduHomeworkUsers;
use app\modules\edu\models\EduHomeworkUsersSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EduHomeworkController implements the CRUD actions for EduHomework model.
 */
class EduHomeworkController extends Controller
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
                            'actions'   => ['user-answer-homework', 'drop-user-answer-homework', 'my-homework-student', 'download'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_USER],
                        ],
                        [
                            'actions'   => ['create', 'update', 'delete', 'teacher-answer', 'my-homework-teacher', 'download'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_TEACHER],
                        ],
                        [
                            'actions'   => ['index'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_ADMINISTRATOR],
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete'                    => ['POST'],
                        'drop-user-answer-homework' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all EduHomework models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $getUserId = Yii::$app->user->id;
        $isTeacher = User::isUserRole($getUserId, User::ROLE_TEACHER);

        $searchModel = new EduHomeworkSearch();

        if ($isTeacher)
        {
            $searchModel->homework_teacher_id = $getUserId;
        }
        else
        {
            $searchModel->is_my_homework = 1;
            $searchModel->status = EduHomework::STATUS_ACTIVE;
        }

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'isTeacher'     => $isTeacher,
        ]);
    }

    public function actionMyHomeworkTeacher()
    {
        $getUserId = Yii::$app->user->id;

        $searchModel = new EduHomeworkSearch();

        $searchModel->homework_teacher_id = $getUserId;

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('myHomeworkTeacher', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider
        ]);
    }

    public function actionMyHomeworkStudent()
    {
        $getUserId = Yii::$app->user->id;

        $searchModel = new EduHomeworkSearch();

        $searchModel->is_my_homework = true;

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('myHomeworkStudent', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider
        ]);
    }


    /**
     * Displays a single EduHomework model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $getUserId = Yii::$app->user->id;
        $isTeacher = User::isUserRole($getUserId, User::ROLE_TEACHER);

        $model = $this->findModel($id);

        $getUserHomework = false;
        $usersHomeworkDataProvider = false;
        $getUserHomeworkAnswerFiles = [];
        if ($isTeacher)
        {
            $usersHomeworkSearchModel = new EduHomeworkUsersSearch();
            $usersHomeworkSearchModel->homework_id = $id;

            $usersHomeworkDataProvider = $usersHomeworkSearchModel->search([]);
        }
        else
        {
            $getUserHomework = $model->answer;
            if ($getUserHomework !== null)
            {
                if (!empty($getUserHomework['homework_answer_ids']))
                {
                    $getUserHomeworkAnswerFiles = CoreFiles::getFiles($getUserHomework['homework_answer_ids']);
                }
            }
        }

        if (!$isTeacher && $getUserHomework !== null && $getUserHomework->homework_user_id != $getUserId)
        {
            throw new ForbiddenHttpException("Запрещено смотреть чужое ДЗ");
        }

        return $this->render('view', [
            'model'                         => $model,
            'homeworkFiles'                 => $model->getHomeworkFiles(),
            'getUserId'                     => $getUserId,
            'getUserHomework'               => $getUserHomework,
            'isTeacher'                     => $isTeacher,
            'usersHomeworkDataProvider'     => $usersHomeworkDataProvider,
            'getUserHomeworkAnswerFiles'    => $getUserHomeworkAnswerFiles,
        ]);
    }

    /**
     * Creates a new EduHomework model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EduHomework();

        if ($this->request->isPost)
        {
            $getUserId = Yii::$app->user->id;
            if ( $model->setEduHomework($this->request->post(), $getUserId) )
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
     * Updates an existing EduHomework model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $getUserId = Yii::$app->user->id;

        if ( $this->request->isPost )
        {
            if ( $model->setEduHomework($this->request->post(), $getUserId, true) )
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /* ===== Студент прикрепляет ответы на дз. ===== */
    public function actionUserAnswerHomework(int $id)
    {
        $getUserId = Yii::$app->user->id;
        $model = $this->findModel($id);

        if ($model->status == EduHomework::STATUS_ACTIVE)
        {
            $eduHomeworkUser = EduHomeworkUsers::findOne(['homework_id' => $id, 'homework_user_id' => $getUserId]);
            if (empty($eduHomeworkUser))
            {
                $eduHomeworkUser = new EduHomeWorkUsers();
                $eduHomeworkUser->homework_id = $id;
                $eduHomeworkUser->homework_user_id = $getUserId;
            }

            if ( $this->request->isPost )
            {
                if ($eduHomeworkUser->load($this->request->post()))
                {
                    if ( $eduHomeworkUser->setHomeworkUser() )
                    {
                        Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
                        return $this->redirect(['view', 'id' => $id]);
                    }
                    else
                    {
                        Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, implode(', ', $eduHomeworkUser->getFirstErrors()));
                    }
                }
            }

            return $this->render('_user_answer_homework', [
                'model' => $eduHomeworkUser,
            ]);
        }

        Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        return $this->redirect(['view', 'id' => $id]);
    }

    /* ===== Студент удаляет свой ответ на дз (Если он ещё не проверен). ===== */
    public function actionDropUserAnswerHomework(int $userAnswerHomeworkId)
    {
        $getUserId = Yii::$app->user->id;

        $model = EduHomeworkUsers::findOne([
            'id'                => $userAnswerHomeworkId,
            'homework_user_id'  => $getUserId,
            'status'            => EduHomeworkUsers::STATUS_WAITING_FOR_VERIFICATION,
        ]);

        if (empty($model))
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
            return $this->redirect(['view', 'id' => $model->homework_id]);
        }

        if ($model->dropHomeworkUser())
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
        }
        else
        {
            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        }

        return $this->redirect(['view', 'id' => $model->homework_id]);
    }

    /* ===== Преподаватель ставит оценку / дает ответ студенту.  ===== */
    public function actionTeacherAnswer(int $homeworkId, int $userId)
    {
        $getUserId = Yii::$app->user->id;
        $model = $this->findModel($homeworkId);

        if ( !$model->isHomeworkTeacher($getUserId) )
        {
            throw new ForbiddenHttpException(MessageHelper::messages()[MessageHelper::KEY_FORBIDDEN]);
        }

        $eduHomeworkUser = EduHomeworkUsers::findOne(['homework_id' => $homeworkId, 'homework_user_id' => $userId]);

        if (!$eduHomeworkUser)
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $answerFiles = [];
        if (!empty($eduHomeworkUser->homework_answer_ids))
        {
            $answerFiles = CoreFiles::getFiles($eduHomeworkUser->homework_answer_ids);
        }

        if ( $this->request->isPost && $eduHomeworkUser->load($this->request->post()) )
        {
            if ( $eduHomeworkUser->setHomeworkUser(EduHomeworkUsers::STATUS_CHECKED) )
            {
                Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
            }
            else
            {
                Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
            }

            return $this->redirect(['view', 'id' => $homeworkId]);
        }

        return $this->renderPartial('_teacher_answer', [
            'model'         => $eduHomeworkUser,
            'answerFiles'   => $answerFiles,
        ]);
    }

    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EduHomework model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EduHomework the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EduHomework::findOne(['id' => $id])) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
