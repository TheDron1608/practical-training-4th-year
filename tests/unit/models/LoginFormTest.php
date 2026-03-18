<?php

namespace tests\unit\models;

use app\modules\core\models\LoginForm;
use app\tests\fixtures\UserFixture;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected string $emailAdmin = 'admin@mail.ru';

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function _fixtures()
    {
        return [
            'user' => UserFixture::class,
        ];
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'email'     => $this->emailAdmin,
            'password'  => 'not_existing_password',
        ]);

        verify($this->model->login())->false();
        verify(\Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'email'     => $this->emailAdmin,
            'password'  => 'wrong_password',
        ]);

        verify($this->model->login())->false();
        verify(\Yii::$app->user->isGuest)->true();
        verify($this->model->errors)->arrayHasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'email'     => $this->emailAdmin,
            'password'  => '1234567',
        ]);

        verify($this->model->login())->true();
        verify(\Yii::$app->user->isGuest)->false();
        verify($this->model->errors)->arrayHasNotKey('password');
    }

}
