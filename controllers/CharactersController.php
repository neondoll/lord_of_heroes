<?php

namespace app\controllers;

use app\models\Characters;
use app\models\CharacterVariationComments;
use app\models\CharacterVariations;
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
                if (in_array($key, ['is_hero', 'large_photo_url', 'small_photo_url'])) {
                    if ($key == 'is_hero') {
                        $character->$key = $item ? 1 : 0;
                    }
                } else {
                    $character->$key = $item;
                }
            }

            $ret = ['success' => $character->save(), 'errors' => $character->getErrors()];
            if ($ret['success']) {
                $name_photos = ['large_photo_url', 'small_photo_url'];
                foreach ($name_photos as $name_photo) {
                    if ($file = UploadedFile::getInstanceByName($name_photo)) {
                        FileHelper::createDirectory(Yii::getAlias("uploads/characters/{$character->id}/{$name_photo}"));
                        $character->$name_photo = "characters/{$character->id}/{$name_photo}/{$file->baseName}.{$file->extension}";
                        $file->saveAs("uploads/{$character->$name_photo}");
                        $character->save();
                    }
                }
            }
            $ret['id'] = $character->id;
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionCreateComment($id_character, $id_variation): string
    {
        if ($post = Yii::$app->request->post()) {
            $post = Json::decode($post['comment'], true);

            $comment = new CharacterVariationComments();
            $comment->id_character_variation = $id_variation;
            $comment->id_user = Yii::$app->user->id;
            $comment->comment = $post;

            $ret = ['success' => $comment->save(), 'errors' => $comment->getErrors()];
        }

        return Json::encode($ret ?? 'Не верный пост');
    }

    public function actionCreateVariation($id_character): string
    {
        if ($post = Yii::$app->request->post()) {
            $post_class = Json::decode($post['id_class'], true);
            $post_element = Json::decode($post['id_element'], true);

            $variation = new CharacterVariations();
            $variation->id_character = $id_character;
            $variation->id_class = $post_class;
            $variation->id_element = $post_element;

            $ret = ['success' => $variation->save(), 'errors' => $variation->getErrors()];
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