<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_subjects}}`.
 */
class m230503_225618_create_edu_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%edu_subjects}}', [
            'id'                        => $this->primaryKey(),
            'subject_teacher_id'        => $this->integer()->notNull()->comment('Id учителя / преподавателя.'),
            'subject_qualification_id'  => $this->integer()->null()->comment('Id квалификации.'),
            'subject_title'             => $this->string(255)->notNull()->comment('Название предмета.'),
            'subject_about'             => $this->string(255)->null()->comment('О предмете.'),
            'status'                    => "SET('active', 'deactivated') NOT NULL",
        ]);

        $this->createIndex('i-edu_subjects-subject_title', '{{%edu_subjects}}', 'subject_title');
        $this->addForeignKey(
            'fk-edu_subjects-subject_teacher_id-user-id',
            '{{%edu_subjects}}',
            'subject_teacher_id',
            '{{%user}}',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-edu_subjects-subject_qualification_id-edu_qualifications-id',
            '{{%edu_subjects}}',
            'subject_qualification_id',
            '{{%edu_qualifications}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-edu_subjects-subject_teacher_id-user-id', '{{%edu_subjects}}');
        $this->dropForeignKey('fk-edu_subjects-subject_qualification_id-edu_qualifications-id', '{{%edu_subjects}}');
        $this->dropTable('{{%edu_subjects}}');
    }
}