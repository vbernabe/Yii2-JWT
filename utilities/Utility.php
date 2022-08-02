<?php

namespace app\utilities;


use Yii;

/**
 * Utility classes
 */
class Utility
{
    /**
     * Use this to hash password on db
     *
     * @param $username
     * @param $pw
     * @return string
     */
    public static function hashPassword($username, $pw){
        $salt =  hash('sha256', $username . '|||' . YII::$app->params['salt']);
        $hashed_password = hash('sha256', $pw . $salt);
        return $hashed_password;
    }

    /**
     * Use this method to validate password from db
     *
     * @param $username
     * @param $pw
     * @param $db_pw
     * @return bool
     */
    public static function validatePassword($username, $pw, $db_pw){
        if(Utility::hashPassword($username, $pw) == $db_pw){
            return true;
        }
        return false;
    }
}