<?php

require_once("./config.php");


if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
			case 'saveHeadData' : saveHeadData();
			break;
	}
}


function saveHeadData() {
	global $connect;
	$response = array();

	//Отправляем новые значения для периодов дат в Базу Данных
	$periods = (isset($_POST["periods"]) && is_array($_POST["periods"])) ? json_encode($_POST["periods"]) : '';
	$hotel_id = (isset($_POST["hotel_id"])) ? $_POST["hotel_id"] : false;

	if(!$hotel_id) {
		die("Нет идентификатора гостиницы");
	}
	
	$req = $connect->prepare("INSERT INTO `table_head` (`hotel_id`,`value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `hotel_id` = VALUES(`hotel_id`), `value` = VALUES(`value`);");
	if($req->execute(array($hotel_id, $periods))) {

		$response = array("status" => "success", "text" => "Запись успешно сохранена");

	} else {

		$response = array("status" => "error", "text" => "Ошибка сохранения в Базу Данных");

	}

	header('Content-type: application/json');
	echo json_encode($response);

}


function getDataHeading($hotel_id) {
	global $connect;

	if(!$hotel_id) {
		die("Нет идентификатора гостиницы");
	}

	$req = $connect->prepare("SELECT value FROM `table_head` WHERE `hotel_id` = ?");
	$req->execute(array($hotel_id));
	$data = $req->fetchColumn();

	return $data;

}




?>