<?php

namespace app\modules\core\controllers;

use app\modules\core\models\GroupsUsers;
use app\modules\core\models\helpers\MessageHelper;
use app\modules\core\models\LoginForm;
use app\modules\core\models\SignupForm;
use app\modules\core\models\User;
use app\modules\core\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions'   => ['login', 'signup'],
                            'allow'     => true,
                            'roles'     => ['?'],
                        ],
                        [
                            'actions'   => ['view', 'update', 'user-card', 'logout'],
                            'allow'     => true,
                            'roles'     => ['@'],
                        ],
                        [
                            'actions'   => ['index', 'create', 'delete'],
                            'allow'     => true,
                            'roles'     => [User::ROLE_ADMINISTRATOR, User::ROLE_CURATOR],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                ],
            ]
        );
    }

    /* ===== Список пользователей. ===== */
    public function actionIndex()
    {
        $searchModel    = new UserSearch();
        $dataProvider   = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }

    /* ===== Мой профиль. ===== */
    public function actionView($id = null)
    {
        $getUserId = $id ?? Yii::$app->user->id;
        $model = $this->findModel($getUserId);

        $userGroups = false;
        if (User::isUserRole($getUserId, User::ROLE_USER))
        {
            $userGroups = GroupsUsers::getUserGroups($getUserId);
        }

        return $this->render('view', [
            'model'         => $model,
            'userGroups'    => $userGroups,
        ]);
    }

    /* ===== Карточка пользователя. ===== */
    public function actionUserCard(int $id)
    {
        $model = $this->findModel($id);

        return $this->render('user_card', [
            'model' => $model,
        ]);
    }

    /* ===== Создание пользователя. ===== */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_USER_CREATE;

        if (Yii::$app->request->isPost)
        {
            if ( $model->createUser(Yii::$app->request->post()) )
            {
                Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
                return $this->redirect('index');
            }

            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /* ===== Редактирование пользователя. ===== */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost)
        {
            if ( $model->updateUser($this->request->post()) )
            {
                Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
                return $this->redirect(['view', 'id' => $id]);
            }

            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id) 
    {
        $model = $this->findModel($id);

        if ($this->request->isPost)
        {
            try {
                if ( $model->delete() )
                {
                    Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
                    return $this->redirect('index');
                }
            }
            catch (yii\db\IntegrityException $e) {
                $model->status = User::STATUS_DELETED;
                if ($model->save()) {
                    Yii::$app->session->setFlash(MessageHelper::KEY_SUCCESS, MessageHelper::messages()[MessageHelper::KEY_SUCCESS]);
                    return $this->redirect('index');
                }
            }

            Yii::$app->session->setFlash(MessageHelper::KEY_DANGER, MessageHelper::messages()[MessageHelper::KEY_DANGER]);
        }

        return $this->render('index');
    }

    /*************************************************
     * ===== НАЧАЛО: АВТОРИЗАЦИЯ && РЕГИСТРАЦИЯ. =====
     * ===============================================
     */

    /* ===== Регистрация. ===== */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ( Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) )
        {
            if ($user = $model->signup())
            {
                if (Yii::$app->user->login($user))
                {
                    return $this->redirect(Yii::$app->homeUrl);
                }
            }

            Yii::$app->session->setFlash('danger', Yii::t('app', 'Error!'));
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /* ===== Авторизация. ===== */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goHomeDependedOnRole();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /************************************************
     * ===== КОНЕЦ: АВТОРИЗАЦИЯ && РЕГИСТРАЦИЯ. =====
     * ==============================================
     */

    /* ===== Выйти из аккаунта. ===== */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function findModel(int $id)
    {
        if ($model = User::findOne($id))
        {
            return $model;
        }

        throw new NotFoundHttpException('Error');
    }

    private function goHomeDependedOnRole() 
    {
        $roles = User::getUserRoles();

        if (in_array(User::ROLE_ADMINISTRATOR, $roles)) {
            $this->redirect('/admin');
        }
        else {
            $this->goHome();
        }
    }
}
