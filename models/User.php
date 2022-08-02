<?php

namespace app\models;

use app\utilities\Utility;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $pw
 * @property string $password
 * @property string $last_login
 *
 * @property Doctor[] $doctors
 * @property Patient[] $patients
 * @property RefreshToken[] $refreshTokens
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'pw', 'password'], 'required'],
            [['last_login'], 'safe'],
            [['username', 'pw'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'pw' => 'Pw',
            'password' => 'Password',
            'last_login' => 'Last Login',
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


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->password = Utility::hashPassword($this->username, $this->password);
            // If this is a new record refresh the token
            if ($this->isNewRecord) {
                // Generate refresh token
                RefreshToken::generateRefreshToken($this);
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * Gets query for [[AccessTokens]].
     *
     * @return \yii\db\ActiveQuery|AccessTokenQuery
     */
    public function getAccessTokens()
    {
        return $this->hasMany(AccessToken::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Doctors]].
     *
     * @return \yii\db\ActiveQuery|DoctorQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Patients]].
     *
     * @return \yii\db\ActiveQuery|PatientQuery
     */
    public function getPatients()
    {
        return $this->hasMany(Patient::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[RefreshTokens]].
     *
     * @return \yii\db\ActiveQuery|RefreshTokenQuery
     */
    public function getRefreshTokens()
    {
        return $this->hasMany(RefreshToken::className(), ['user_id' => 'id']);
    }


    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Make sure access token is valid, if not return invalid token error. Need to genereate a new access token based on refresh token
        return static::find()
            ->where(['id' => (string) $token->getClaim('user')[0]->uid ])
            ->one();
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Utility::validatePassword($this->username, $password, $this->password);
    }

    /**
     * @return mixed
     */
    public function generateJwt() {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        $jwtParams = Yii::$app->params['jwt'];

        $claim = array([
            'uid' => $this->id,
            'role' => $this->getRole(),
        ]);

        return $jwt->getBuilder()
            ->issuedBy($jwtParams['issuer'])
            ->permittedFor($jwtParams['audience'])
            ->identifiedBy($jwtParams['id'], true)
            ->issuedAt($time)
            ->expiresAt($time + $jwtParams['expire'])
            ->withClaim('user' , $claim)
            ->getToken($signer, $key);
    }

    /**
     * @return array
     */
    public function getRole(){
        $roles = array();
        if(Doctor::findOne(['user_id' => $this->id])){
            $roles[] = Yii::$app->params['ROLE_DOCTOR'];
        }
        if(Patient::findOne(['user_id' => $this->id])){
            $roles[] = Yii::$app->params['ROLE_PATIENT'];
        }
        return $roles;
    }

}