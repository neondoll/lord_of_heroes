<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%characters}}`.
 */
class m210501_200812_add_columns_to_characters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('characters', 'large_photo_url', $this->string());
        $this->addColumn('characters', 'small_photo_url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('characters', 'large_photo_url');
        $this->dropColumn('characters', 'small_photo_url');
    }
}
