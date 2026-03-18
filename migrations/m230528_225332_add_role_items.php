<?php

use app\modules\core\models\User;
use yii\db\Migration;

/**
 * Class m230528_225332_add_role_items
 */
class m230528_225332_add_role_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $transaction = Yii::$app->db->beginTransaction();

        foreach (User::ROLE_ALL as $role)
        {
            $role = $auth->createRole($role);
            if (!$auth->add($role))
            {
                $transaction->rollBack();
                return false;
            }
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
