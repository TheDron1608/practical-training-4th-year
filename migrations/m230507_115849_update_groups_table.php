<?php

use yii\db\Migration;

/**
 * Class m230507_115849_update_groups_table
 */
class m230507_115849_update_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%groups}}', 'group_qualification_id', $this->integer()->null()->comment('Id квалификации.'));
        $this->addForeignKey(
            'fk-groups-group_qualification_id-edu_qualifications-id',
            '{{%groups}}',
            'group_qualification_id',
            '{{%edu_qualifications}}',
            'id',
            'SET NULL',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-groups-group_qualification_id-edu_qualifications-id', '{{%groups}}');
        $this->dropColumn('{{%groups}}', 'group_qualification_id');
    }
}