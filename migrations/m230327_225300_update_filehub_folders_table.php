<?php

use yii\db\Migration;

/**
 * Class m230327_225300_update_filehub_folders_table
 */
class m230327_225300_update_filehub_folders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%filehub_folders}}', 'folder_about', $this->string(1024)->null()->comment('MY - для меня, COMMON - для общего списка.'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%filehub_folders}}', 'folder_about', $this->string(1024)->notNull()->comment('MY - для меня, COMMON - для общего списка.'));
    }
}
