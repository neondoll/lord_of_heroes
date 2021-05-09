<?php

namespace app\controllers\api;

use app\models\CharacterVariations;
use yii\rest\Controller;

class CharacterVariationsController extends Controller
{
    public function actionIndex($id_character): array
    {
        $variations = [];
        foreach (CharacterVariations::findAll(['id_character' => $id_character, 'system_status' => 1]) as $characterVariation) {
            $comments = [];
            foreach ($characterVariation->comments as $comment) {
                $comments[] = [
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at,
                    'id' => $comment->id,
                    'id_character_variation' => $comment->id_character_variation,
                    'id_user' => $comment->id_user,
                    'system_status' => $comment->system_status,
                    'updated_at' => $comment->updated_at,
                    'user' => $comment->user
                ];
            }
            $variations[] = [
                'class' => $characterVariation->class,
                'comments' => $comments,
                'created_at' => $characterVariation->created_at,
                'element' => $characterVariation->element,
                'id' => $characterVariation->id,
                'id_character' => $characterVariation->id_character,
                'id_class' => $characterVariation->id_class,
                'id_element' => $characterVariation->id_element,
                'new_comment' => '',
                'system_status' => $characterVariation->system_status,
                'updated_at' => $characterVariation->updated_at
            ];
        }
        return $variations;
    }

    public function actionLabels(): array
    {
        return (new CharacterVariations())->attributeLabels();
    }
}