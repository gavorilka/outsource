<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Exception;


/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $token
 *
 * @property OrderDetail[] $orderDetails
 * @property Orders[] $orders
 * @property Performers[] $performers
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function isReal($attribute, $params)
    {
        $user = self::findOne(['login' => $this->login]);

        if(!$user || $user->password != $this->password)
            $this->addError('login', 'login or password incorrect');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login'],'isReal', 'on' => ['login']],
            [['password'], 'string', 'max' => 16],
            [['token'], 'string', 'max' => 32],
            //[['login'], 'unique'],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'login',
            'password' => 'Password',
            'token' => 'Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerformers()
    {
        return $this->hasMany(Performers::className(), ['user' => 'id']);
    }

    //find
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @return array
     * @throws yii\base\Exception
     */
    public function login()
    {
        if($this->validate()) {

            $user = self::findOne(['login' => $this->login]);

            $user->token = Yii::$app->security->generateRandomString();
            $user->save();

            return [
                'login' => $this->login,
                'password'=> $this->password,
                'access_token' => $user->token
            ];
        } else {
            return [
                'errors' => $this->errors
            ];
        }
    }
}