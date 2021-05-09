<?php

namespace app\controllers\api;

use app\models\Classes;
use yii\rest\Controller;

class ClassesController extends Controller
{
    public function actionIndex(): array
    {
        return Classes::find()->where(['system_status' => 1])->orderBy('name')->all();
    }

    public function actionLabels(): array
    {
        return (new Classes())->attributeLabels();
    }
}