<?php

return [
    'database' => [
        'name' => 'lamp',
        'username' => 'lamp',
        'password' => 'lamp',
        'host' => 'mysql:host=database',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],
//    'test_database' => [
//        'name' => 'test_lamp',
//        'username' => 'lamp',
//        'password' => 'lamp',
//        'host' => 'mysql:host=database',
//        'options' => [
//            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
//        ]
//    ],
    'palindrome_points' => 3,
    'almost_palindrome_points' => 2,
    'date_format' => 'm/d/Y',
    'time_format' => 'H:i:s'
];