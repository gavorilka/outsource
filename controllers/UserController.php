<?php

namespace app\controllers;

use app\models\User;
use Yii;

class UserController extends ApiController
{
    public $modelClass = User::class;


    public function actions()
    {
        $actions = parent::actions();

       // unset($actions['login']);
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);

        return $actions;
    }

    public function actionLogin()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(),'');
        $user->scenario = 'login';
        return $user->login();
    }
}