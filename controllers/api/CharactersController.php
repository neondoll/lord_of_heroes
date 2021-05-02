<?php

namespace app\controllers\api;

use app\models\Characters;
use Yii;
use yii\rest\Controller;

class CharactersController extends Controller
{
    public function actionIndex(): array
    {
        return Characters::find()->where(['system_status' => 1])->orderBy('name')->all();
    }

    public function actionLabels(): array
    {
        return (new Characters())->attributeLabels();
    }

    public function actionView($id_character): array
    {
        $character = Characters::findOne($id_character);

        return [
            'character' => $character,
            'large_photo_url' => Yii::$app->assetManager->publish(Yii::getAlias('@webroot') . '/uploads/' . $character->large_photo_url)[1],
            'race' => $character->race
        ];
    }
}