<?php

namespace tests\unit\models;

use app\modules\core\models\User;
use app\tests\fixtures\UserFixture;

class UserTest extends \Codeception\Test\Unit
{
    protected int $userAdminId = 1;

    protected string $emailAdmin = 'admin@mail.ru';
    protected string $userAdminAuthKey = 'v-N79kiPC1TGB1kdXSCdLLAtLqSY_Ts_Ma1ZrfAc2uoOlOf_1XnJPgP88PKuAt_LrnZRbmeqolil8Bj1AAUxnM0cvygIdmWqLZ-gUwGQQmHFvPiZfyyj-UI1NXMlMiPR';

    public function _fixtures()
    {
        return [
            'user' => UserFixture::class,
        ];
    }

    public function testFindUserById()
    {
        verify($user = User::findIdentity($this->userAdminId))->notEmpty();
        verify($user->user_f)->equals('Admin');

        verify(User::findIdentity(999))->empty();
    }

    public function testFindUserByEmail()
    {
        verify($user = User::findByEmail($this->emailAdmin))->notEmpty();
        verify(User::findByEmail('not-admin'))->empty();
    }

    public function testValidateUser()
    {
        $user = User::findByEmail($this->emailAdmin);
        verify($user->validateAuthKey($this->userAdminAuthKey))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('1234567'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

    public function testCreateUsers()
    {
        
    }
}