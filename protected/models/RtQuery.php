<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Rt]].
 *
 * @see Rt
 */
class RtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Rt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Rt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
