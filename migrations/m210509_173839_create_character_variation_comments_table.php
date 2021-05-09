<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%character_variation_comments}}`.
 */
class m210509_173839_create_character_variation_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%character_variation_comments}}', [
            'id' => $this->primaryKey(),
            'id_character_variation' => $this->integer(),
            'id_user' => $this->integer(),
            'comment' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'system_status' => $this->tinyInteger()->defaultValue(1)
        ]);
        $this->addForeignKey('fk-character_variation_comments-id_character_variation', 'character_variation_comments', 'id_character_variation', 'character_variations', 'id');
        $this->addForeignKey('fk-character_variation_comments-id_user', 'character_variation_comments', 'id_user', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%character_variation_comments}}');
    }
}
