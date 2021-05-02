<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "character_variations".
 *
 * @property int $id
 * @property int|null $id_character
 * @property int|null $id_class
 * @property int|null $id_element
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $system_status
 *
 * @property Characters $character
 * @property Classes $class
 * @property Elements $element
 */
class CharacterVariations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'character_variations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_character', 'id_class', 'id_element', 'system_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_character'], 'exist', 'skipOnError' => true, 'targetClass' => Characters::className(), 'targetAttribute' => ['id_character' => 'id']],
            [['id_class'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['id_class' => 'id']],
            [['id_element'], 'exist', 'skipOnError' => true, 'targetClass' => Elements::className(), 'targetAttribute' => ['id_element' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_character' => 'Id Character',
            'id_class' => 'Id Class',
            'id_element' => 'Id Element',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'system_status' => 'System Status',
        ];
    }

    /**
     * Gets query for [[Character]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacter()
    {
        return $this->hasOne(Characters::className(), ['id' => 'id_character']);
    }

    /**
     * Gets query for [[Class]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classes::className(), ['id' => 'id_class']);
    }

    /**
     * Gets query for [[Element]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getElement()
    {
        return $this->hasOne(Elements::className(), ['id' => 'id_element']);
    }
}
