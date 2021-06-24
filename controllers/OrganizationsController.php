<?php

namespace app\controllers;

use app\models\Organizations;

class OrganizationsController extends \app\controllers\ApiController
{
    public $modelClass = 'app\models\Organizations';

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
        return Organizations::find()->select('id, name')->all();
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
