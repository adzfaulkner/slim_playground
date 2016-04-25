<?php

return [
    'settings' => [
        'displayErrorDetails'   => true,
        'db'    => [
            'driver'   => 'pdo_pgsql',
            'host'     => 'localhost',
            'dbname'   => 'main',
            'user'     => 'postgres',
            'password' => '123',
        ],
        'mail'  => [
            'from'      => [
                'email'     => 'test@slim.dev',
                'name'      => 'Slim Dev',
            ],
        ],
    ],
];

