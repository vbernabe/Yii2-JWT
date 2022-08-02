<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RefreshToken]].
 *
 * @see RefreshToken
 */
class RefreshTokenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RefreshToken[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RefreshToken|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
