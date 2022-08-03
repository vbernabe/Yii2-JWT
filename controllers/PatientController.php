<?php

namespace app\controllers;

use app\models\Doctor;
use app\utilities\HttpStatus;
use Yii;
use app\models\Patient;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class PatientController extends Controller
{
    public $modelClass = Patient::class;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {   $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = \sizeg\jwt\JwtHttpBearerAuth::class;
        return $behaviors;

    }

//    public function actions()
//    {
//        $actions = parent::actions();
//        unset($actions['index']);
//        return $actions;
//    }

    /**
     * Get all patient for this user based on access token
     * @return array
     */
    public function actionIndex(){
        $this->checkAccess('index');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // get doctor patient map
        $doctor = Doctor::findOne(['user_id' => Yii::$app->user->identity->id]);
        $doctor_patient_map = $doctor->getDoctorPatientMaps()->all();
        $patients = array();
        foreach($doctor_patient_map as $doctor_patient){
            // get patient details
            $patient = $doctor_patient->getPatient()->one();
            if(!empty($patient))
                $patients[] = $patient;
        }
        return [
            'status' => HttpStatus::OK,
            'data' => $patients
        ];
    }

    /**
     * Access Control check if user role is doctor then show patient record
     *
     * @param $action
     * @param $model
     * @param $params
     * @return void
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'index') {
            if(!in_array(Yii::$app->params['ROLE_DOCTOR'], Yii::$app->user->identity->getRole())){
                Yii::info("User trying to get resource without access " . Yii::$app->user->identity->username , Yii::$app->params['log_api']);
                throw new ForbiddenHttpException("You do not have permission to view these records.");
            }
        }

    }
}