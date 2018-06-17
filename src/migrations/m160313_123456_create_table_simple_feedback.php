<?php

use yii\db\Migration;

class m160313_123456_create_table_simple_feedback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%simple_feedback}}', [
            'id' => $this->primaryKey(),
            'rating' => $this->tinyInteger(),
            'comment' => $this->string(1024),
            'target' => $this->string(1024),
            'rated_at' => $this->dateTime(),
            'rated_by' => $this->string(128),
        ]);
        $this->createIndex('IX_SIM_FEE_RAT_18', '{{%simple_feedback}}', 'rating');
        $this->createIndex('IX_SIM_FEE_TAR_19', '{{%simple_feedback}}', 'target');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%simple_feedback}}');
    }
}
