<?php

namespace tests\unit\utilities;

use app\utilities\Utility;

/**
 * Unit test for Utility.php
 *
 * Run test on the command line
 * vendor\bin\codecept run tests\unit\utilities
 */
class UtilityTest extends \Codeception\Test\Unit
{
    private $username = 'jdoe';
    private $password = 'xiek3DaiPX9A';
    private $hashPassword = 'f98130350cbd906506dace989ece806d38b81b4e6cd98d7f50c8997b561402ec';


    public function testHashPassword()
    {   $hash_password =  Utility::hashPassword($this->username, $this->password);
        expect($this->hashPassword)->equals($hash_password);
    }

    public function testValidatePassword()
    {   $isValidPw =  Utility::validatePassword($this->username, $this->password, $this->hashPassword);
        expect($isValidPw)->equals(true);
    }
}
