<?php
use Model\ActiveRecord; 
require __DIR__ . '/../vendor/autoload.php';
require 'funciones.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);