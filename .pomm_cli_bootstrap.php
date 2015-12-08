<?php

use PommProject\Foundation\Pomm;

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add(null, __DIR__);

return new Pomm(['db' => [
    'dsn' => getenv('DATABASE_URL') ?: 'pgsql://maxime:maxime@localhost:5432/green',
    'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
]]);
