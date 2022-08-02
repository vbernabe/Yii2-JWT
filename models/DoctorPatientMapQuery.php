<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DoctorPatientMap]].
 *
 * @see DoctorPatientMap
 */
class DoctorPatientMapQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DoctorPatientMap[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DoctorPatientMap|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
