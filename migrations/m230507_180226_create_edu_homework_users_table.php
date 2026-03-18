<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_homework_users}}`.
 */
class m230507_180226_create_edu_homework_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%edu_homework_users}}', [
            'id'                        => $this->primaryKey(),
            'homework_id'               => $this->integer()->notNull()->comment('Id дз.'),
            'homework_user_id'          => $this->integer()->notNull()->comment('Id того кому задали.'),
            'homework_answer_ids'       => $this->json()->null()->comment('Ids прикрепляных файлов.'),
            'homework_answer_comment'   => $this->string(2048)->null()->comment('Коммент ответа на дз.'),
            'homework_grade'            => $this->integer()->null()->comment('Оценка за дз.'),
            'homework_teacher_comment'  => $this->string(2048)->null()->comment('Комментирий от того кто задал.'),
            'status'                    => $this->string(32)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-edu_homework_users-homework_id-edu_homework-id',
            '{{%edu_homework_users}}',
            'homework_id',
            '{{%edu_homework}}',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-edu_homework_users-homework_user_id-user-id',
            '{{%edu_homework_users}}',
            'homework_user_id',
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
        $this->dropForeignKey('fk-edu_homework_users-homework_id-edu_homework-id', '{{%edu_homework_users}}');
        $this->dropForeignKey('fk-edu_homework_users-homework_user_id-user-id', '{{%edu_homework_users}}');
        $this->dropTable('{{%edu_homework_users}}');
    }
}
