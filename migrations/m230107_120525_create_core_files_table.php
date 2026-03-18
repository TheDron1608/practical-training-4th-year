<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%core_files}}`.
 */
class m230107_120525_create_core_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%core_files}}', [
            'id'                => $this->primaryKey(),
            'file_user_id'      => $this->integer()->notNull()->comment('Кто создал.'),
            'file_title'        => $this->string(255)->notNull()->comment('Имя файла.'),
            'file_patch'        => $this->string(255)->notNull()->comment('Путь к файлу.'),
            'file_hash'         => $this->string(255)->notNull()->comment('Зашифрованный путь к файлу.'),
            'file_comment'      => $this->string(512)->null()->comment('Комментарий к файлу.'),
            'file_extension'    => $this->string(10)->notNull()->comment('Расширение файла.'),
            'file_size'         => $this->integer()->notNull()->comment('Размер файла.'),
            'file_code'         => $this->string(50)->notNull()->comment('Код файла (Пример: Аватар).'),
            'status'            => "SET('active', 'deleted') NOT NULL",
            'created_at'        => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%core_files}}');
    }
}