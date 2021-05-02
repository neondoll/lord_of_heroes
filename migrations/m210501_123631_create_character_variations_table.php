<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%character_variations}}`.
 */
class m210501_123631_create_character_variations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%character_variations}}', [
            'id' => $this->primaryKey(),
            'id_character' => $this->integer(),
            'id_class' => $this->integer(),
            'id_element' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'system_status' => $this->tinyInteger()->defaultValue(1)
        ]);
        $this->addForeignKey('fk-character_variations-id_character', 'character_variations', 'id_character', 'characters', 'id');
        $this->addForeignKey('fk-character_variations-id_class', 'character_variations', 'id_class', 'classes', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%character_variations}}');
    }
}
