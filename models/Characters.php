<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "characters".
 *
 * @property string $created_at
 * @property string|null $description
 * @property string|null $dob
 * @property string|null $favorite_food
 * @property string|null $form_of_appeal
 * @property int|null $height
 * @property int $id
 * @property int|null $id_race
 * @property int|null $is_hero
 * @property string|null $large_photo_url
 * @property string|null $name
 * @property string|null $small_photo_url
 * @property int|null $system_status
 * @property string $updated_at
 * @property string|null $values
 *
 * @property CharacterVariations[] $characterVariations
 * @property Races $race
 */
class Characters extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'created_at' => 'Created At',
            'description' => 'Описание',
            'dob' => 'День рождения',
            'favorite_food' => 'Любимая еда',
            'form_of_appeal' => 'Форма обращения',
            'height' => 'Рост',
            'id' => 'ID',
            'id_race' => 'Id Race',
            'is_hero' => 'Герой',
            'large_photo_url' => 'Большое изображение',
            'name' => 'Имя',
            'small_photo_url' => 'Маленькое изображение',
            'race' => 'Раса',
            'system_status' => 'System Status',
            'updated_at' => 'Updated At',
            'values' => 'Ценности'
        ];
    }

    /**
     * Gets query for [[CharacterVariations]].
     *
     * @return ActiveQuery
     */
    public function getCharacterVariations(): ActiveQuery
    {
        return $this->hasMany(CharacterVariations::className(), ['id_character' => 'id']);
    }

    /**
     * Gets query for [[Race]].
     *
     * @return ActiveQuery
     */
    public function getRace(): ActiveQuery
    {
        return $this->hasOne(Races::className(), ['id' => 'id_race']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at', 'dob', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [[
                'favorite_food', 'form_of_appeal', 'large_photo_url', 'name', 'small_photo_url', 'values'
            ], 'string', 'max' => 255],
            [['height', 'id_race', 'is_hero', 'system_status'], 'integer'],
            [['id_race'], 'exist', 'skipOnError' => true, 'targetClass' => Races::className(), 'targetAttribute' => ['id_race' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'characters';
    }
}
