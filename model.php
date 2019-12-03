<?php

require_once("./config.php");
require_once("./functions.php");


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
	$periods = (isset($_POST["periods"])) ? json_decode($_POST["periods"]) : '';
	$group_id = (isset($_POST["group_id"])) ? $_POST["group_id"] : false;

	if(!$group_id) {
		$response = array("status" => "error", "text" => "Нет идентификатора гостиницы");
		die($response);
	}

	if (!is_array($periods)) {
		$response = array("status" => "error", "text" => "Неверный формат данных периодов");
		die($response);
	}

	
	$req = $connect->prepare("UPDATE `nwty-periods` SET `head_content` = (?) WHERE `hotel_id` = ?;");
	if($req->execute(array($periods, $group_id))) {

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