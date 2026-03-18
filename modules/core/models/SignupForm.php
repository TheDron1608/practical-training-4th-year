<?php


namespace app\modules\core\models;


use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    const SCENARIO_REQUIRED = 'scenario_required';

    public $user_f;
    public $user_i;
    public $user_o;
    public $email;
    public $password;
    public $role;

    public function rules()
    {
        return [
            [['user_f', 'user_i', 'email', 'password'], 'required'],
            [['user_f', 'user_i', 'user_o', 'email', 'password'], 'trim'],
            [['user_f', 'user_i', 'user_o'], 'string', 'max' => 50],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => Yii::t('app', 'Email')],
            ['password', 'string', 'min' => 6, 'max' => 64],
            ['role', 'required', 'on' => self::SCENARIO_REQUIRED],
            ['role', 'in', 'range' => User::ROLE_ALL],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_f'        => Yii::t('app', 'Фамилия'),
            'user_i'        => Yii::t('app', 'Имя'),
            'user_o'        => Yii::t('app', 'Отчество'),
            'email'         => Yii::t('app', 'Почта'),
            'password'      => Yii::t('app', 'Пароль'),
            'role'          => Yii::t('app', 'Роль'),
        ];
    }

    /* ===== Регистрация. ===== */
    public function signup()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try
        {
            if (!$this->validate())
            {
                return null;
            }

            /* ===== Начало: Создать пользователя. ===== */
            $user = new User();

            $user->user_f           = $this->user_f;
            $user->user_i           = $this->user_i;
            $user->user_o           = $this->user_o;
            $user->email            = $this->email;
            $user->last_visit_at    = time();
            $user->generateAuthKey();
            $user->setPassword($this->password);

            if (!$user->save())
            {
                throw new \Exception('Error No Save');
            }

            $role = User::ROLE_USER;
            if (!empty($this->role))
            {
                $role = $this->role;
            }
            /* ===== Конец: Создать пользователя. ===== */

            /* ===== Начало: Добавить роль пользователю. ===== */
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($role);
            if (!$auth->assign($role, $user->getId()))
            {
                throw new \Exception('Error No Role');
            }
            /* ===== Конец: Добавить роль пользователю. ===== */
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            return null;
        }

        $transaction->commit();
        return $user;
    }
}