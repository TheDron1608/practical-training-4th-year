<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%groups}}`.
 */
class m230114_180528_create_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%groups}}', [
            'id'                => $this->primaryKey(),
            'group_author_id'   => $this->integer()->notNull()->comment('Id автора.'),
            'group_curator_id'  => $this->integer()->null()->comment('Id куратора группы.'),
            'group_title'       => $this->string(255)->notNull()->comment('Название группы.'),
            'group_about'       => $this->string(1500)->null()->comment('О группе.'),
            'group_options'     => $this->json()->null()->comment('Доп. настройки.'),
            'status'            => "SET('active', 'deleted') NOT NULL",
            'created_at'        => $this->integer()->notNull(),
            'updated_at'        => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-groups-group_curator_id-user-id',
            '{{%groups}}',
            'group_curator_id',
            '{{%user}}',
            'id',
            'SET NULL',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-groups-group_curator_id-user-id', '{{%groups}}');
        $this->dropTable('{{%groups}}');
    }
}
