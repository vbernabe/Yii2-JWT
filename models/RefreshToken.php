<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "refresh_token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $ip
 * @property string $agent
 * @property string $created_at
 *
 * @property User $user
 */
class RefreshToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refresh_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['token', 'ip', 'agent'], 'required'],
            [['created_at'], 'safe'],
            [['token', 'agent'], 'string', 'max' => 1000],
            [['ip'], 'string', 'max' => 50],
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
            'token' => 'Token',
            'ip' => 'Ip',
            'agent' => 'Agent',
            'created_at' => 'Created At',
        ];
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
     * @return RefreshTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefreshTokenQuery(get_called_class());
    }

    /**
     * @param User $user
     * @param User|null $impersonator
     * @return UserRefreshToken
     * @throws \yii\base\Exception
     * @throws \yii\web\ServerErrorHttpException
     */
    public static function generateRefreshToken($user, $impersonator = null) {
        // TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
        $db_refresh_token = User::findOne($user->id)->getRefreshTokens()->one();
        if(empty($db_refresh_token)){
            $refresh_token = Yii::$app->security->generateRandomString(200);

            $db_refresh_token = new RefreshToken();
            $db_refresh_token->user_id = $user->id;
            $db_refresh_token->token = $refresh_token;
            $db_refresh_token->ip = Yii::$app->request->userIP;
            $db_refresh_token->agent = Yii::$app->request->userAgent;
            $db_refresh_token->created_at = gmdate('Y-m-d H:i:s');

            if (!$db_refresh_token->save()) {
                throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token: '. $db_refresh_token->getErrorSummary(true));
            }
        } else {
            $refresh_token = $db_refresh_token->token;
        }

        return $db_refresh_token;
    }
}
