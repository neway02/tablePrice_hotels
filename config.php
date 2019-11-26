<?php


$host = '127.0.0.1';
$db   = 'table_price_module';
$user = 'root';
$pass = '';
$charset = 'utf8';

$auth_db = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
];


$connect = new PDO($auth_db, $user, $pass, $opt);



?>