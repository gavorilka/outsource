<?php

namespace app\controllers;

use app\models\Professions;

class ProfessionsController extends \app\controllers\ApiController
{
    public $modelClass = 'app\models\Professions';

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['view']);

        unset($actions['create']);
        unset($actions['delete']);
        unset($actions['update']);

        return $actions;
    }

    public function actionIndex()
    {
        return Professions::find()->select('id, name')->all();
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        /*$behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className()
        ];
        /*$behaviors['authenticator'] = [
            'class' => \yii\filters\auth\QueryParamAuth::className(),
            'tokenParam'=>'read'
        ];*/
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];


        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = \app\models\User::findOne(['token' => $username]);
        if ($user){
            return $user->password == $password ? $user : null;
        }

    }



}
