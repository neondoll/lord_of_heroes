<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%races}}`.
 */
class m210501_114920_create_races_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%races}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'system_status' => $this->tinyInteger()->defaultValue(1)
        ]);
        $this->addForeignKey('fk-characters-id_race', 'characters', 'id_race', 'races', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-characters-id_race', 'characters');
        $this->dropTable('{{%races}}');
    }
}
