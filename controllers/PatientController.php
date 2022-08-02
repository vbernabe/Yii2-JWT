<?php

namespace app\controllers;

use Yii;
use app\models\Patient;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class PatientController extends ActiveController
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