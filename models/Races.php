<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "races".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $system_status
 *
 * @property Characters[] $characters
 */
class Races extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'system_status' => 'System Status'
        ];
    }

    /**
     * Gets query for [[Characters]].
     *
     * @return ActiveQuery
     */
    public function getCharacters(): ActiveQuery
    {
        return $this->hasMany(Characters::className(), ['id_race' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['system_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'races';
    }
}
