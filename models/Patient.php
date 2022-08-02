<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "patient".
 *
 * @property int $id
 * @property int $user_id
 * @property string $fname
 * @property string|null $lname
 * @property string $email
 * @property string $diagnosis
 * @property string $created_at
 * @property string $updated_at
 *
 * @property DoctorPatientMap[] $doctorPatientMaps
 * @property User $user
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fname', 'email', 'diagnosis'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['fname', 'lname', 'email'], 'string', 'max' => 50],
            [['diagnosis'], 'string', 'max' => 150],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'email' => 'Email',
            'diagnosis' => 'Diagnosis',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string[]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * Gets query for [[DoctorPatientMaps]].
     *
     * @return \yii\db\ActiveQuery|DoctorPatientMapQuery
     */
    public function getDoctorPatientMaps()
    {
        return $this->hasMany(DoctorPatientMap::className(), ['patient_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return PatientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PatientQuery(get_called_class());
    }
}
