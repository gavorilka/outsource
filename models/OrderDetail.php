<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property int $id

 * @property int $performer
 * @property int $profession
 * @property int $organization
 * @property int $order_id
 * @property string $date_or_status
 * @property int $days
 *

 * @property Performers $performer0
 * @property Professions $profession0
 * @property Organizations $organization0
 * @property Orders $order
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['performer', 'profession', 'organization', 'date_or_status', 'days'], 'required'],
            [['performer', 'profession', 'organization', 'order_id', 'days'], 'integer'],
            [['date_or_status'], 'isCorrect'],
            [['date_or_status'], 'isCorrect', 'on' => 'upd'],
            //[['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
            [['performer'], 'exist', 'skipOnError' => true, 'targetClass' => Performers::className(), 'targetAttribute' => ['performer' => 'id']],
            [['profession'], 'exist', 'skipOnError' => true, 'targetClass' => Professions::className(), 'targetAttribute' => ['profession' => 'id']],
            [['organization'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    public function isCorrect($attribute, $params)
    {
        if (!is_integer($this->date_or_status) || $this->date_or_status < 0 || $this->date_or_status > 2147483647)
        if(!in_array($this->date_or_status, ['completed', 'performed']))
            $this->addError('date_or_status', 'error: Value must be completed or performed or unix-timestamp!');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'user' => 'User',
            'performer' => 'Performer',
            'profession' => 'Profession',
            'organization' => 'Organization',
            'order_id' => 'Order ID',
            'date_or_status' => 'Date Or Status',
            'days' => 'Days',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     *//*
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer0()
    {
        return $this->hasOne(Performers::className(), ['id' => 'performer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfession0()
    {
        return $this->hasOne(Professions::className(), ['id' => 'profession']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization0()
    {
        return $this->hasOne(Organizations::className(), ['id' => 'organization']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
}
