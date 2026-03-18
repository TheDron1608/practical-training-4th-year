<?php

use app\modules\core\models\User;
use yii\db\Migration;

/**
 * Class m230528_230518_add_user_administration
 */
class m230528_230518_add_user_administration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $time = time();

        try
        {
            $this->insert('{{%user}}', [
                'id'                    => 1,
                'avatar_id'             => null,
                'user_f'                => 'admin',
                'user_i'                => 'admin',
                'user_o'                => null,
                'email'                 => 'admin@mail.ru',
                'access_token'          => null,
                'auth_key'              => Yii::$app->security->generateRandomString(),
                'password_hash'         => Yii::$app->security->generatePasswordHash('rty4545t6dfB'),
                'password_reset_token'  => null,
                'about'                 => null,
                'options'               => null,
                'status'                => User::STATUS_ACTIVE,
                'created_at'            => $time,
                'updated_at'            => $time,
                'last_visit_at'         => $time,
            ]);

            $auth = Yii::$app->authManager;
            if ( !$auth->assign($auth->getRole(User::ROLE_ADMINISTRATOR), 1) )
            {
                throw new \Exception('Error No Assign');
            }
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
