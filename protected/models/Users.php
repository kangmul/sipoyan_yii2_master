<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $nickname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property bool $is_active
 * @property string $role
 * @property int $role_id
 * @property string|null $api_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $expired
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
            [['first_name', 'username', 'email', 'password', 'nik', 'no_hp', 'rt', 'rw'], 'required'],
            [['is_active'], 'boolean'],
            [['role_id', 'expired'], 'default', 'value' => null],
            [['role_id', 'expired'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['email', 'password', 'role'], 'string', 'max' => 255],
            [['api_token'], 'string', 'max' => 512],
            [['email'], 'unique'],
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
            'is_active' => 'Is Active',
            'role' => 'Role',
            'role_id' => 'Role ID',
            'api_token' => 'Api Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'expired' => 'Expired',
            'nik' => 'NIK',
            'rt' => 'RT',
            'rw' => 'RW'
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
        return self::findOne(['username' => $username]);
    }

}
