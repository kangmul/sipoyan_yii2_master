<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rt}}".
 *
 * @property int $id
 * @property string|null $rt
 * @property bool|null $is_active
 * @property string|null $created_by
 * @property string|null $updated_by
 */
class Rt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rt}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['updated_by'], 'safe'],
            [['rt'], 'string', 'max' => 3],
            [['created_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rt' => 'Rt',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RtQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RtQuery(get_called_class());
    }
}
