<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property int $user_id
 * @property string $fname
 * @property string|null $lname
 * @property string $email
 * @property string $specialization
 * @property string $created_at
 * @property string $updated_at
 *
 * @property DoctorPatientMap[] $doctorPatientMaps
 * @property User $user
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fname', 'email', 'specialization'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['fname', 'lname', 'email', 'specialization'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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


//    public function fields()
//    {
//        return ['user_id','created_at'];
//    }

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
            'specialization' => 'Specialization',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[DoctorPatientMaps]].
     *
     * @return \yii\db\ActiveQuery|DoctorPatientMapQuery
     */
    public function getDoctorPatientMaps()
    {
        return $this->hasMany(DoctorPatientMap::className(), ['doctor_id' => 'id']);
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
     * @return DoctorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DoctorQuery(get_called_class());
    }

    /**
     * Get all patient of this doctor
     *
     * @return array of patient object
     */
    public function getPatients()
    {
        // Get the doctor patient mapping
        $doc_patient_map = $this->getDoctorPatientMaps()->all();
        $patients = array();

        // retrieve all patient data per mapping
        foreach($doc_patient_map as $doc_patient){
            array_push($patients, $doc_patient->getPatient()->one());
        }
        return $patients;
    }
}
