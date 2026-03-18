<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_qualifications}}`.
 */
class m230503_223047_create_edu_qualifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%edu_qualifications}}', [
            'id'                    => $this->primaryKey(),
            'qualification_title'   => $this->string(255)->notNull(),
            'qualification_about'   => $this->string(4096)->null(),
            'status'                => "SET('active', 'deactivated') NOT NULL"
        ]);

        $this->createIndex('i-edu_qualifications-qualification_title', '{{%edu_qualifications}}', 'qualification_title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%edu_qualifications}}');
    }
}
