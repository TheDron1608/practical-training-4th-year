<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230105_213242_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id'                    => $this->primaryKey(),
            'avatar_id'             => $this->integer()->null()->comment('Id картинки пользователя.'),
            'user_f'                => $this->string(50)->notNull(),
            'user_i'                => $this->string(50)->notNull(),
            'user_o'                => $this->string(50)->null(),
            'email'                 => $this->string(255)->notNull()->unique(),
            'access_token'          => $this->string(255)->null()->unique(),
            'auth_key'              => $this->string(255)->notNull(),
            'password_hash'         => $this->string(255)->notNull(),
            'password_reset_token'  => $this->string(255)->null(),
            'about'                 => $this->string(255)->null(),
            'options'               => $this->json()->null(),
            'status'                => $this->smallInteger()->defaultValue(10)->notNull(),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
            'last_visit_at'         => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
