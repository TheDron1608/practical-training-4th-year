<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_homework}}`.
 */
class m230507_143020_create_edu_homework_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%edu_homework}}', [
            'id'                        => $this->primaryKey(),
            'homework_teacher_id'       => $this->integer()->notNull()->comment('Id учителя который задал дз.'),
            'homework_group_id'         => $this->integer()->notNull()->comment('Id группы в которой задали это дз.'),
            'homework_subject_id'       => $this->integer()->notNull()->comment('Id предмета по которому задали дз.'),
            'homework_answer_file_id'   => $this->integer()->null()->comment('Id файл с ответом на дз.'),
            'homework_file_ids'         => $this->json()->null()->comment('Ids прикрепленных файлов.'),
            'homework_title'            => $this->string(512)->notNull(),
            'homework_content'          => $this->string(8192)->null()->comment('Содержание/Комментарий.'),
            'homework_deadline'         => $this->dateTime()->null()->comment('К какому времени нужно сдать дз.'),
            'homework_options'          => $this->json()->null()->comment('Доп. настройки к дз.'),
            'status'                    => $this->string(32)->notNull(),
            'created_at'                => $this->integer()->notNull(),
            'updated_at'                => $this->integer()->notNull(),
        ]);

        $this->createIndex('i-edu_homework-homework_title', '{{%edu_homework}}', 'homework_title');

        $this->addForeignKey(
            'fk-edu_homework-homework_teacher_id-user-id',
            '{{%edu_homework}}',
            'homework_teacher_id',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey(
            'fk-edu_homework-homework_group_id-groups-id',
            '{{%edu_homework}}',
            'homework_group_id',
            '{{%groups}}',
            'id'
        );

        $this->addForeignKey(
            'fk-edu_homework-homework_subject_id-edu_subjects-id',
            '{{%edu_homework}}',
            'homework_subject_id',
            '{{%edu_subjects}}',
            'id'
        );

        $this->addForeignKey(
            'fk-edu_homework-homework_answer_file_id-core_files-id',
            '{{%edu_homework}}',
            'homework_answer_file_id',
            '{{%core_files}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-edu_homework-homework_teacher_id-user-id', '{{%edu_homework}}');
        $this->dropForeignKey('fk-edu_homework-homework_group_id-groups-id', '{{%edu_homework}}');
        $this->dropForeignKey('fk-edu_homework-homework_subject_id-edu_subjects-id', '{{%edu_homework}}');
        $this->dropForeignKey('fk-edu_homework-homework_answer_file_id-core_files-id', '{{%edu_homework}}');

        $this->dropTable('{{%edu_homework}}');
    }
}
