<?php

return [
    'defaults' => [
        'guard' => 'users',
        'passwords' => 'users',
    ],

    'guards' => [
        'admins' => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],
        'users' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ]
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ]
    ]

];
