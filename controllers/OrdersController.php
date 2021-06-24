<?php

namespace app\controllers;

use app\models\Orders;
use app\models\OrderDetail;
use Yii;
use yii\web\NotFoundHttpException;


class OrdersController extends ApiController
{
    public $modelClass = 'app\models\Orders';

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
        return Orders::find()->where(['user' => Yii::$app->user->id])->select('id, name')->all();
    }

    public function actionCreate()
    {
        $orders = new Orders();
        $orders->load(Yii::$app->request->post(), '');
        $orders->user = Yii::$app->user->id;
        if($orders->validate() && $orders->save(false))
            return $orders->id;//возвращает id при удачи

        return $orders->errors;
    }

    public function actionDelete($id)
    {
        $orders = Orders::findOne($id);

        if(!$orders || $orders->user != Yii::$app->user->id)
            return [
                'success' => false
            ];

        if($orders->delete())
            return [
                'success' => true
            ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className()
        ];

        return $behaviors;
    }
}
