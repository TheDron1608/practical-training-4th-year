<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%edu_subjects_groups}}`.
 */
class m230503_230204_create_edu_subjects_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%edu_subjects_groups}}', [
            'id'            => $this->primaryKey(),
            'subject_id'    => $this->integer()->notNull(),
            'group_id'      => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-edu_subjects_groups-subject_id-edu_subjects-id',
            '{{%edu_subjects_groups}}',
            'subject_id',
            '{{%edu_subjects}}',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-edu_subjects_groups-group_id-groups-id',
            '{{%edu_subjects_groups}}',
            'group_id',
            '{{%groups}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-edu_subjects_groups-subject_id-edu_subjects-id', '{{%edu_subjects_groups}}');
        $this->dropForeignKey('fk-edu_subjects_groups-group_id-groups-id', '{{%edu_subjects_groups}}');
        $this->dropTable('{{%edu_subjects_groups}}');
    }
}
