<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "character_variation_comments".
 *
 * @property string|null $comment
 * @property string $created_at
 * @property int $id
 * @property int|null $id_character_variation
 * @property int|null $id_user
 * @property int|null $system_status
 * @property string $updated_at
 *
 * @property CharacterVariations $characterVariation
 * @property User $user
 */
class CharacterVariationComments extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'id_character_variation' => 'Id Character Variation',
            'id_user' => 'Id User',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'system_status' => 'System Status',
        ];
    }

    /**
     * Gets query for [[CharacterVariation]].
     *
     * @return ActiveQuery
     */
    public function getCharacterVariation(): ActiveQuery
    {
        return $this->hasOne(CharacterVariations::className(), ['id' => 'id_character_variation']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_character_variation', 'id_user', 'system_status'], 'integer'],
            [['id_character_variation'], 'exist', 'skipOnError' => true, 'targetClass' => CharacterVariations::className(), 'targetAttribute' => ['id_character_variation' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'character_variation_comments';
    }
}
