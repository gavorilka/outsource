<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "performers".
 *
 * @property int $id
 * @property string $fio
 * @property string $profession
 * @property string $photo
 * @property int $user
 *
 * @property OrderDetail[] $orderDetails
 * @property User $user0
 */
class Performers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'performers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'profession', 'photo', 'user'], 'required'],
            [['user'], 'integer'],
            [['fio', 'profession', 'photo'], 'string', 'max' => 128],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'profession' => 'Profession',
            'photo' => 'Photo',
            'user' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['performer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
