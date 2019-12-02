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
		$response = array("status" => "error", "text" => "Нет идентификатора гостиницы");
		die($response);
	}
	
	$req = $connect->prepare("UPDATE `nwyt-group` SET `head_content` = (?) WHERE `hotel_id` = ?;");
	if($req->execute(array($periods, $hotel_id))) {

		$response = array("status" => "success", "text" => "Запись успешно сохранена");

	} else {

		$response = array("status" => "error", "text" => "Ошибка сохранения в Базу Данных");

	}

	header('Content-type: application/json');
	echo json_encode($response);

}


function getDataHeading($group_id) {
	global $connect;

	if(!$group_id) {
		die("Нет идентификатора гостиницы");
	}

	$req = $connect->prepare("SELECT date_from, date_to, count FROM `nwty-periods` WHERE `group_id` = ?");
	$req->execute(array($group_id));
	$data = $req->fetchAll();


	echo "<pre>";
	print_r($data);
	echo "</pre>";

	return $data;

}




?>