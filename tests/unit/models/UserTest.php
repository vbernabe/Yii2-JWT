<?php

namespace tests\unit\models;

use app\models\User;
use app\utilities\Utility;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserByAccessToken()
    {
        $user = new User();
        $user->id = '1';
        $user->username = 'jdoe';
        $user->password = Utility::hashPassword('jdoe', 'jdoepw');
        $user->save();

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IlppZVctT0RrRGt3cHF2Qjc4d09AOTJDMGFrSWFDIn0.eyJpc3MiOiJodHRwczpcL1wvYXBpLnR0aS5jb20iLCJhdWQiOiJodHRwczpcL1wvZnJvbnRlbmQudHRpLmNvbSIsImp0aSI6IlppZVctT0RrRGt3cHF2Qjc4d09AOTJDMGFrSWFDIiwiaWF0IjoxNjU5NDUyNDQ4LCJleHAiOjE2NTk0NTI3NDgsInVzZXIiOlt7InVpZCI6MSwicm9sZSI6WyJkb2N0b3IiXX1dfQ.z69Je5zQv7l0pqn9zq_-yI-fjqicuDWjhxqyC42bCao";
        $jwt = new sizeg\jwt\JwtHttpBearerAuth();
        $jwt_token = $jwt->loadToken($token);
        expect_that($user = User::findIdentityByAccessToken($jwt_token));
        expect($user->username)->equals('jdoe');
    }

}
