<p align="center">
    <h1 align="center">Yii 2 Basic Project Template API implementation with JWT</h1>
    <br>
</p>


The project is a REST API with JWT Authentication. Authorization used is based on access token
with 5 minutes expiration time.

Access token should be regenerated once it expired using the Refresh Token or via Login again.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project is PHP with Yii2 and MySQL for database.

INSTALLATION
------------

You can run thru below if you want to install this on a localhost or just use the service as provided
on an AWS (see below after install)

### Install 

Clone from this repo and import the MySQL dump file. 

~~~
$ git clone https://github.com/vbernabe/yii2-jwt.git yii2-jwt
~~~

Update the db config `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2-jwt',
    'username' => 'user',
    'password' => 'pwd',
    'charset' => 'utf8',
];
```

install dependencies via composer and run the yii server.

~~~
$ cd yii2-jwt
$ composer install
$ yii serve
~~~

### Access
Now you should be able to access the application through the following URL.

~~~
http://localhost:8080
~~~

ACCESS INSTANCE ONLY
------------
This code has been deployed on EC2 AWS for testing

~~~
https://34.211.45.94/
~~~

[//]: # ()
[//]: # ()
[//]: # (TESTING)

[//]: # (-------)

[//]: # ()
[//]: # (Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework]&#40;http://codeception.com/&#41;.)

[//]: # ()
[//]: # (Tests can be executed by running)

[//]: # ()
[//]: # (```)

[//]: # (vendor/bin/codecept run)

[//]: # (```)

[//]: # ()
[//]: # (The command above will execute unit and functional tests. Unit tests are testing the system components, while functional)

[//]: # (tests are for testing user interaction. )


API ENDPOINTS
-------------

### /auth/
API Endpoint for Authorization.

```
/auth/login = to login to the app which return an access token
/auth/refresh-token = this endpoint is for retrievieng a new access token or removing refresh token
```

### /patient/
API Endpoint for patient details

```
/patient = retrieve patient info given that the access token used is from role = doctor
```

### For detailed API Documention
With request response head to https://documenter.getpostman.com/view/16128439/UzkayZnF
