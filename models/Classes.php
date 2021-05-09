<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $system_status
 *
 * @property CharacterVariations[] $characterVariations
 */
class Classes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'system_status' => 'System Status',
        ];
    }

    /**
     * Gets query for [[CharacterVariations]].
     *
     * @return ActiveQuery
     */
    public function getCharacterVariations(): ActiveQuery
    {
        return $this->hasMany(CharacterVariations::className(), ['id_class' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['system_status'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'classes';
    }
}
