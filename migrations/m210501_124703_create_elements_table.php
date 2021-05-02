<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%elements}}`.
 */
class m210501_124703_create_elements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%elements}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'color' => $this->string(),
            'system_status' => $this->tinyInteger()->defaultValue(1)
        ]);
        $this->addForeignKey('fk-character_variations-id_element', 'character_variations', 'id_element', 'elements', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-character_variations-id_element', 'character_variations');
        $this->dropTable('{{%elements}}');
    }
}
