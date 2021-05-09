<?php

namespace app\controllers;

use app\models\Classes;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ClassesController extends Controller
{
    private $labels = ['index' => 'Классы'];

    public function actionCreate(): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['name'], true);

            $class = new Classes();
            $class->name = $post;

            $ret = ['success' => $class->save(), 'errors' => $class->getErrors()];
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionIndex(): string
    {
        return $this->render('/index', ['breadcrumbs' => [$this->labels['index']]]);
    }
}