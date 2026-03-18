<?php

namespace app\controllers;

use app\modules\core\models\User;
use app\modules\edu\models\EduHomeworkUsers;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions'   => ['login'],
                        'allow'     => true,
                        'roles'     => ['?'],
                    ],
                    [
                        'actions'   => ['index'],
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['/filehub/']);

        $getUserId = Yii::$app->user->id;
        $res = [];

        $isTeacher = User::isUserRole($getUserId, User::ROLE_TEACHER);
        if ($isTeacher)
        {

        }
        else
        {
            $res['homework-user-status-waiting-for-an-answer'] = [
                'count' => EduHomeworkUsers::getHomeworkCountByStatus(null, $getUserId),
                'url'   => Url::to('/edu/edu-homework/index'),
            ];
        }

        return $this->render('index', [
            'res' => $res,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->redirect('/core/user/login');
    }
}
