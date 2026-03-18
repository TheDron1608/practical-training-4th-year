<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%filehub_folders}}`.
 */
class m230325_160956_create_filehub_folders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%filehub_folders}}', [
            'id'                => $this->primaryKey(),
            'folder_owner_id'   => $this->integer()->notNull()->comment('Id ответственного за папку.'),
            'folder_parent_id'  => $this->integer()->null()->comment('Id папки в которой он находиться.'),
            'folder_title'      => $this->string(255)->notNull()->comment('Название папки.'),
            'folder_about'      => $this->string(1024)->notNull()->comment('MY - для меня, COMMON - для общего списка.'),
            'folder_code'       => "SET('my', 'common') NOT NULL",
            'status'            => "SET('active', 'draft') NOT NULL",
            'created_at'        => $this->integer()->notNull(),
        ]);

        $this->createIndex('filehub_folders-folder_title-index', '{{%filehub_folders}}', 'folder_title');
        $this->addForeignKey(
            'fk-filehub_folders-folder_owner_id-user-id',
            '{{%filehub_folders}}',
            'folder_owner_id',
            '{{%user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-filehub_folders-folder_owner_id-user-id', '{{%filehub_folders}}');
        $this->dropTable('{{%filehub_folders}}');
    }
}
