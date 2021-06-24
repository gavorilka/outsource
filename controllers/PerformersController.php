<?php

namespace app\controllers;

use app\models\Performers;
use Yii;



class PerformersController extends ApiController
{
    public $modelClass = 'app\models\Performers';

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
        return Performers::find()->where(['user' => Yii::$app->user->id])->select('id, fio, photo, profession')->all();
    }

    /*public function actionDevices($id)
    {
        $performers = Performers::findOne(['id' => $id, 'user' => Yii::$app->user->id]);

        if(!$performers)
            return [];

        return $performers->devices;
    }*/

    public function actionView($id)
    {
        $performers = Performers::findOne(['id' => $id, 'user' => Yii::$app->user->id]);

        if(!$performers)
            return null;

        unset($performers->user);

        return $performers;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        /*$behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className()
        ];*/
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\QueryParamAuth::className(),
            'tokenParam'=>'read'
        ];
        /*$behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];*/


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
