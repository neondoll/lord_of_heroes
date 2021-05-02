<?php

namespace app\controllers;

use app\models\Characters;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class CharactersController extends Controller
{
    private $labels = ['index' => 'Герои'];

    public function actionAdd(): string
    {
        return $this->render('/index', ['breadcrumbs' => [
            ['label' => $this->labels['index'], 'url' => ['index']],
            'Добавление героя'
        ]]);
    }

    public function actionCreate(): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['character'], false);

            $character = new Characters();

            foreach ($post as $key => $item) {
                if (in_array($key, ['is_hero'])) {
                    $character->$key = $item ? 1 : 0;
                } else {
                    $character->$key = $item;
                }
            }

            $ret = ['success' => $character->save(), 'errors' => $character->getErrors()];
            $ret['id'] = $character->id;
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionEdit($id_character): string
    {
        $character = Characters::findOne($id_character);
        return $this->render('/index', ['breadcrumbs' => [
            ['label' => $this->labels['index'], 'url' => ['index']],
            ['label' => $character->name, 'url' => ['view', 'id_character' => $id_character]],
            'Редактирование героя'
        ]]);
    }

    public function actionIndex(): string
    {
        return $this->render('/index', ['breadcrumbs' => [$this->labels['index']]]);
    }

    public function actionUpdate($id_character): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['character'], false);

            $character = Characters::findOne($id_character);

            foreach ($post as $key => $item) {
                if (in_array($key, ['id', 'is_hero', 'large_photo_url', 'small_photo_url'])) {
                    if ($key == 'is_hero') {
                        $character->$key = $item ? 1 : 0;
                    }
                } else {
                    $character->$key = $item;
                }
            }
            $name_photos = ['large_photo_url', 'small_photo_url'];
            foreach ($name_photos as $name_photo) {
                if ($file = UploadedFile::getInstanceByName($name_photo)) {
                    FileHelper::createDirectory(Yii::getAlias("uploads/characters/{$character->id}/{$name_photo}"));
                    $character->$name_photo = "characters/{$character->id}/{$name_photo}/{$file->baseName}.{$file->extension}";
                    $file->saveAs("uploads/{$character->$name_photo}");
                }
            }

            $ret = ['success' => $character->save(), 'errors' => $character->getErrors()];
            $ret['id'] = $character->id;
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionView($id_character): string
    {
        $character = Characters::findOne($id_character);
        return $this->render('/index', ['breadcrumbs' => [
            ['label' => $this->labels['index'], 'url' => ['index']],
            $character->name
        ]]);
    }
}