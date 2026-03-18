<?php

use yii\db\Migration;

/**
 * Class m230326_115809_update_core_files_table
 */
class m230326_115809_update_core_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%core_files}}',
            'file_folder_id',
            $this->integer()->null()->comment('Id папки в которой находиться файл.')->after('file_user_id')
        );

        $this->addForeignKey(
            'fk-core_files-file_folder_id-filehub_folders-id',
            '{{%core_files}}',
            'file_folder_id',
            '{{%filehub_folders}}',
            'id',
            'SET NULL',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%core_files}}', 'file_folder_id');
        $this->dropForeignKey('fk-core_files-file_folder_id-filehub_folders-id', '{{%core_files}}');
    }
}