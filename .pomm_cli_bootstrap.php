<?php

use PommProject\Foundation\Pomm;


$loader = require __DIR__.'/vendor/autoload.php';
$loader->add(null, __DIR__);

return new Pomm(['db' =>
    [
        'dsn' => 'pgsql://hewrdngzmoezev:79xgD8rrTZzSJkHCbNQCJxrcWM@ec2-54-83-53-120.compute-1.amazonaws.com:5432/d5o0bc1t160bqg',
        'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
    ]
]);

