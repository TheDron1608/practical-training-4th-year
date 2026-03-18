<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%groups_users}}`.
 */
class m230114_180539_create_groups_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%groups_users}}', [
            'id'        => $this->primaryKey(),
            'group_id'  => $this->integer()->notNull()->comment('Id группы.'),
            'user_id'   => $this->integer()->notNull()->comment('Id пользователя.'),
            'user_role' => "SET('author', 'moder', 'user', 'curator') NOT NULL"
        ]);

        $this->addForeignKey(
            'fk-groups_users-group_id-groups-id',
            '{{%groups_users}}',
            'group_id',
            '{{%groups}}',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-groups_users-user_id-user-id',
            '{{%groups_users}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-groups_users-group_id-groups-id', '{{%groups_users}}');
        $this->dropForeignKey('fk-groups_users-user_id-user-id', '{{%groups_users}}');
        $this->dropTable('{{%groups_users}}');
    }
}
