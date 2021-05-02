<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%classes}}`.
 */
class m210501_122731_create_classes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%classes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'system_status' => $this->tinyInteger()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%classes}}');
    }
}
