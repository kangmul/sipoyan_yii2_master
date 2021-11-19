<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tac}}".
 *
 * @property int $id
 * @property string|null $termandcond
 * @property string|null $is_active
 * @property string|null $created_by
 * @property string|null $created_date
 */
class Tac extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tac}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['termandcond'], 'string'],
            [['created_date'], 'safe'],
            [['is_active', 'created_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'termandcond' => 'Termandcond',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
        ];
    }
}
