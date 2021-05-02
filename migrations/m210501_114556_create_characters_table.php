<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%characters}}`.
 */
class m210501_114556_create_characters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%characters}}', [
            'id' => $this->primaryKey(),
            'form_of_appeal' => $this->string(),
            'name' => $this->string(),
            'id_race' => $this->integer(),
            'height' => $this->integer(),
            'dob' => $this->date(),
            'values' => $this->string(),
            'favorite_food' => $this->string(),
            'description' => $this->text(),
            'is_hero' => $this->tinyInteger(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'system_status' => $this->tinyInteger()->defaultValue(1)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%characters}}');
    }
}
