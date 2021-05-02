<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $system_status
 *
 * @property CharacterVariations[] $characterVariations
 */
class Classes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['system_status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'system_status' => 'System Status',
        ];
    }

    /**
     * Gets query for [[CharacterVariations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterVariations()
    {
        return $this->hasMany(CharacterVariations::className(), ['id_class' => 'id']);
    }
}
