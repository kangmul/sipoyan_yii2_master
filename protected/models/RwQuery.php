<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Rw]].
 *
 * @see Rw
 */
class RwQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Rw[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Rw|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
