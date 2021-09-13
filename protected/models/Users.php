<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $email
 * @property string|null $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property bool|null $is_active
 * @property string|null $created_by
 * @property string|null $created_date
 * @property bool|null $validate
 * @property int|null $role_id
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'rt', 'no_hp', 'alamat', 'username'], 'required'],
            [['email'], 'email'],
            [['is_active', 'validate'], 'boolean'],
            [['created_date'], 'safe'],
            [['role_id'], 'default', 'value' => null],
            [['role_id'], 'integer'],
            [['username', 'email', 'password', 'authKey', 'accessToken', 'created_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'validate' => 'Validate',
            'role_id' => 'Role ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'rt' => 'RT',
            'username' => 'Username',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username, 'is_active' => true]);
    }

    public static function findIdentity($id)
    {
        return isset(self::$id) ? new static(self::$id) : null;
    }
}
