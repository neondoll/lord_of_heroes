<?php

namespace app\controllers\api;

use app\models\Elements;
use yii\rest\Controller;

class ElementsController extends Controller
{
    public function actionIndex(): array
    {
        return Elements::find()->where(['system_status' => 1])->orderBy('name')->all();
    }

    public function actionLabels(): array
    {
        return (new Elements())->attributeLabels();
    }
}