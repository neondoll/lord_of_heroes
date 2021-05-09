<?php

namespace app\controllers\api;

use app\models\User;
use Yii;
use yii\rest\Controller;

class UsersController extends Controller
{
    public function actionCurrent(): array
    {
        $user = Yii::$app->user;
        $can = 'guest';
        foreach (['root', 'admin', 'user'] as $role) {
            if ($user->can($role)) {
                $can = $role;
                break;
            }
        }

        return [
            'can' => $can,
            'user' => User::findOne(Yii::$app->user->id) ?? ['id' => 0]
        ];
    }
}