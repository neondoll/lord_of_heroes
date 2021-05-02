<?php

namespace app\controllers;

use app\models\Elements;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class ElementsController extends Controller
{
    private $labels = ['index' => 'Стихии'];

    public function actionCreate(): string
    {
        if ($post = Yii::$app->request->post()) {
            $post_name = Json::decode($post['name'], true);
            $post_color = Json::decode($post['color'], true);

            $element = new Elements();
            $element->name = $post_name;
            $element->color = $post_color;

            $ret = ['success' => $element->save(), 'errors' => $element->getErrors()];
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionIndex(): string
    {
        return $this->render('/index', ['breadcrumbs' => [$this->labels['index']]]);
    }
}