<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "doctor_patient_map".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $patient_id
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Doctor $doctor
 * @property Patient $patient
 */
class DoctorPatientMap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor_patient_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'patient_id'], 'required'],
            [['doctor_id', 'patient_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['patient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Patient::className(), 'targetAttribute' => ['patient_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'patient_id' => 'Patient ID',
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
     * Gets query for [[Doctor]].
     *
     * @return \yii\db\ActiveQuery|DoctorQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }

    /**
     * Gets query for [[Patient]].
     *
     * @return \yii\db\ActiveQuery|PatientQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    /**
     * {@inheritdoc}
     * @return DoctorPatientMapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DoctorPatientMapQuery(get_called_class());
    }
}
