<?php

use PommProject\Foundation\Pomm;

$loader = require __DIR__.'/vendor/autoload.php';
$loader->add(null, __DIR__);

$database_url = getenv('DATABASE_URL');
$database_url = explode("//", $database_url);
$database_url = "pgsql://" . $database_url; 

var_dump($database_url);
die();

return new Pomm(['db' => [
    'dsn' => getenv('DATABASE_URL') ?: 'pgsql://maxime:maxime@localhost:5432/green',
    'class:session_builder' => '\PommProject\ModelManager\SessionBuilder',
]]);
