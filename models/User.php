<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $password
 * @property string $auth_token
 * @property string $email
 * @property int $activity
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public $password2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'password', 'auth_token', 'email'], 'required'],
            [['activity'], 'integer'],
            [['last_name', 'first_name', 'password'], 'string', 'max' => 45],
            [['auth_token', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 6, 'tooShort' => 'Длина пароля менее 6 символов'],
            [['password'], 'trim'],
            ['password', 'match', 'pattern' => '/^[a-z0-9]+$/i', 'message'=>'Только буквы a-z и цифры 0-9'],
            ['password2', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают" ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'email' => 'Email',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'password' => 'Пароль',
            'password2' => 'Пароль повторно',
        ];
    }

    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
}
