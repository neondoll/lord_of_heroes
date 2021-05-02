<?php

namespace app\controllers;

use app\models\Races;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class RacesController extends Controller
{
    private $labels = ['index' => 'Расы'];

    public function actionCreate(): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['name'], true);

            $race = new Races();
            $race->name = $post;

            $ret = ['success' => $race->save(), 'errors' => $race->getErrors()];
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionIndex(): string
    {
        return $this->render('/index', ['breadcrumbs' => [$this->labels['index']]]);
    }
}