<?php
require_once("./vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$mysql = mysqli_connect($_ENV['SERVER'],$_ENV['DB_USERNAME'],$_ENV['DB_PASSWORD'],$_ENV['DATABASE']);

if(!$mysql){
die("DB connection error! ". mysqli_connect_error());
}
?>