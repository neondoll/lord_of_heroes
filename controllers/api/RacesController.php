<?php

namespace app\controllers\api;

use app\models\Races;
use yii\rest\Controller;

class RacesController extends Controller
{
    public function actionIndex(): array
    {
        return Races::find()->where(['system_status' => 1])->orderBy('name')->all();
    }

    public function actionLabels(): array
    {
        return (new Races())->attributeLabels();
    }
}