<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rw}}".
 *
 * @property int $id
 * @property string|null $rw
 * @property string|null $created_at
 * @property string|null $created_by
 */
class Rw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rw}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['rw'], 'string', 'max' => 5],
            [['created_by'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rw' => 'Rw',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RwQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RwQuery(get_called_class());
    }
}
