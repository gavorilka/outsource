<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $name
 * @property int $user
 *
 * @property OrderDetail[] $orderDetails
 */
class Orders extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    public $detail;

    public function fields()
    {
        return array_merge(parent::fields(), [
            'detail' => 'orderDetails'
        ]);
    }
    public function beforeValidate()
    {
        $temp = [];

        if(!isset($this->detail)) $this->detail = [];

        foreach ($this->detail as $det) {
            $orderDetails = new OrderDetail();

            if(isset($det['performer']))
                $orderDetails->performer = $det['performer'];
            if(isset($det['profession']))
                $orderDetails->profession = $det['profession'];
            if(isset($det['organization']))
                $orderDetails->organization = $det['organization'];
            if(isset($det['date_or_status']))
                $orderDetails->date_or_status = $det['date_or_status'];
            if(isset($det['days']))
                $orderDetails->days = $det['days'];


            $temp[] = $orderDetails;
        }

        $this->detail = $temp;

        return parent::beforeValidate();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail'], 'required'],
            [['detail'], 'detailValidation'],
            [['name'], 'required'],
            [['user'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        foreach ($this->detail as $det) {
            $det->order_id = $this->id;
            //$det->user = Yii::$app->user->id;
            $det->save(false);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function detailValidation($attributes, $params)
    {
        foreach ($this->detail as $key => $det)
            if(!$det->validate())
                $this->addError('detail['.$key.']', $det->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
