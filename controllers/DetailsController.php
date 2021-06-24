<?php

namespace app\controllers;

use app\models\OrderDetail;
use app\models\Orders;
use Yii;
use yii\web\NotFoundHttpException;

class DetailsController extends \app\controllers\ApiController
{
    public $modelClass = 'app\models\OrderDetail';

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

    public function actionView($id)
    {
        $status = OrderDetail::findOne($id);

        if(!$status || !Orders::findOne(['id' => $status->order_id, 'user' => Yii::$app->user->id]))
            return null;

        return $status;
    }

    public function actionUpdate($id)
    {
        $status= OrderDetail::findOne($id);

        if(!$status)
            return new NotFoundHttpException();

        if(!Orders::findOne(['id' => $status->order_id, 'user' => Yii::$app->user->id]))
            return new UnauthorizedHttpException();

        $data = Yii::$app->request->post();

        if(isset($data['status'])) {
            $status->date_or_status = $data['status'];

            $status->scenario = 'upd';

            if($status->validate() && $status->save()) {
                return $status;
            }

            return $status->errors;
        }

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
