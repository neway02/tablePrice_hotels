<?php


//Отправляем новые значения для периодов дат в Базу Данных
$periods = (isset($_POST["periods"]) && is_array($_POST["periods"])) ? json_encode($_POST["periods"]) : '';
$hotel_id = (isset($_POST["hotel_id"])) ? $_POST["hotel_id"] : false;

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


if(!$hotel_id) {
	die("Нет идентификатора гостиницы");
}

print_r($periods);
echo "<br>";
print_r($hotel_id);


$req = $connect->prepare("INSERT INTO `table_head` (`hotel_id`,`value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `hotel_id` = VALUES(`hotel_id`), `value` = VALUES(`value`);");
$req->execute(array($hotel_id, $periods));





?>