<?php

namespace app\controllers;

use Yii;
use app\models\RefreshToken;
use app\utilities\HttpStatus;
use yii\web\Controller;
use app\models\User;

class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {   $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \sizeg\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'refresh-token',
                'options',
            ],
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     *
     * @return array|mixed|string|null
     */
    public function actionLogin(){
        $params = Yii::$app->request->post();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(empty($params['username']) || empty($params['password'])){
            Yii::error("Missing params " . $params['username'], Yii::$app->params['log_api']);
            return [
                'status' => HttpStatus::BAD_REQUEST,
                'message' => "Password and username are required",
                'data' => ''
            ];
        }

        // validate user
        $user = User::findOne(['username' => $params['username']]);
        if($user && $user->validatePassword($params['password'])){
            // get access token if valid, otherwise generate new one and return
            $refresh_token = $user->getRefreshTokens()->one();
            if(empty($refresh_token)){
                Yii::info("New refresh token generated " . $params['username'], Yii::$app->params['log_api']);
                $refresh_token = RefreshToken::generateRefreshToken($user);
            }
            // Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'refresh-token',
                'value' => $refresh_token->token,
                'httpOnly' => true,
                'sameSite' => 'none',
                'secure' => true,
                'path' => Yii::$app->params['api_refresh_token_path']
            ]));


            // Generate token
            Yii::info("New access token generated " . $params['username'], Yii::$app->params['log_api']);
            $token = $user->generateJwt();
            return [
                'status' => HttpStatus::FOUND,
                'message' => 'Login Succeed, save your token',
                'data' => [
                    'id' => $user->id,
                    'token' => (string) $token,
                ]
            ];

        } else {
            Yii::error("Invalid password" . $params['username'], Yii::$app->params['log_api']);
            Yii::$app->response->statusCode = HttpStatus::UNAUTHORIZED;
            return [
                'status' => HttpStatus::UNAUTHORIZED,
                'message' => 'Username and Password not found. Check Again!',
                'data' => ''
            ];
        }
    }

    /**
     * Generate Refresh Token
     *
     * @return string[]|\yii\web\ServerErrorHttpException|\yii\web\UnauthorizedHttpException
     */
    public function actionRefreshToken() {
        $refresh_token = Yii::$app->request->cookies->getValue('refresh-token', false);
        if (!$refresh_token) {
            Yii::error("Missing cookie refresh token " , Yii::$app->params['log_api']);
            return new \yii\web\UnauthorizedHttpException('No refresh token found.');
        }

        $user_refresh_token = RefreshToken::findOne(['token' => $refresh_token]);

        if (Yii::$app->request->getMethod() == 'POST') {
            // Getting new JWT after it has expired
            if (!$user_refresh_token) {
                Yii::error("Refresh token not in db" , Yii::$app->params['log_api']);
                return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
            }

            $user = User::find()
                ->where(['id' => $user_refresh_token->user_id])
                ->one();
            if (!$user) {
                Yii::info("Removing refresh token not in db" , Yii::$app->params['log_api']);
                $user_refresh_token->delete();
                return new \yii\web\UnauthorizedHttpException('The user is inactive.');
            }

            $token = $user->generateJwt();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'ok',
                'token' => (string) $token,
            ];

        } elseif (Yii::$app->request->getMethod() == 'DELETE') {
            // Logging out
            if ($user_refresh_token && !$user_refresh_token->delete()) {
                return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['status' => 'ok'];
        } else {
            return new \yii\web\UnauthorizedHttpException('The user is inactive.');
        }
    }
}
