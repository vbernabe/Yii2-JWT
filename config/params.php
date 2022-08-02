<?php

return [
    'salt' => 'D?X@E+OaBz778wOp3t6q9O$X&H!L@zoW',
    'yes' => 'Y',
    'no' => 'N',
    'access_token_ttl' => (60*5), // 5 minutes,

    'ROLE_DOCTOR'=> 'doctor',
    'ROLE_PATIENT' => 'patient',

    'jwt' => [
        'issuer' => 'https://api.tti.com',  //name of your project (for information only)
        'audience' => 'https://frontend.tti.com',  //description of the audience, eg. the website using the authentication (for info only)
        'id' => 'ZieW-ODkDkwpqvB78wO@92C0akIaC',  //a unique identifier for the JWT, typically a random string - move to ENV later
        'expire' => (60*5),  //the short-lived JWT token is here set to expire after 5 min.
    ],

    'api_refresh_token_path' => '/api/refresh-token',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token

    'log_api' => 'api', //logging api category
];
