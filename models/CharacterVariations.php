<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "character_variations".
 *
 * @property string $created_at
 * @property int $id
 * @property int|null $id_character
 * @property int|null $id_class
 * @property int|null $id_element
 * @property int|null $system_status
 * @property string $updated_at
 *
 * @property Characters $character
 * @property Classes $class
 * @property CharacterVariationComments[] $comments
 * @property Elements $element
 */
class CharacterVariations extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'class' => 'Класс',
            'created_at' => 'Created At',
            'element' => 'Стихия',
            'id' => 'ID',
            'id_character' => 'Id Character',
            'id_class' => 'Id Class',
            'id_element' => 'Id Element',
            'system_status' => 'System Status',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Character]].
     *
     * @return ActiveQuery
     */
    public function getCharacter(): ActiveQuery
    {
        return $this->hasOne(Characters::className(), ['id' => 'id_character']);
    }

    /**
     * Gets query for [[Class]].
     *
     * @return ActiveQuery
     */
    public function getClass(): ActiveQuery
    {
        return $this->hasOne(Classes::className(), ['id' => 'id_class']);
    }

    /**
     * Gets query for [[CharacterVariationComments]].
     *
     * @return ActiveQuery
     */
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(CharacterVariationComments::className(), ['id_character_variation' => 'id']);
    }

    /**
     * Gets query for [[Element]].
     *
     * @return ActiveQuery
     */
    public function getElement(): ActiveQuery
    {
        return $this->hasOne(Elements::className(), ['id' => 'id_element']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['id_character', 'id_class', 'id_element', 'system_status'], 'integer'],
            [['id_character'], 'exist', 'skipOnError' => true, 'targetClass' => Characters::className(), 'targetAttribute' => ['id_character' => 'id']],
            [['id_class'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['id_class' => 'id']],
            [['id_element'], 'exist', 'skipOnError' => true, 'targetClass' => Elements::className(), 'targetAttribute' => ['id_element' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'character_variations';
    }
}
