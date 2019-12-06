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
	$periods = (isset($_POST["periods"])) ? json_decode($_POST["periods"], TRUE) : '';
	$group_id = (isset($_POST["group_id"])) ? $_POST["group_id"] : false;

	if(!$group_id) {
		$response = array("status" => "error", "text" => "Нет идентификатора гостиницы");
		die($response);
	}

	if (!is_array($periods)) {
		$response = array("status" => "error", "text" => "Неверный формат данных периодов");
		die($response);
	}

	$last_count = 0;
	$binding_values = array();
	$sql = "INSERT INTO `nwty-periods` (`date_from`, `date_to`, `count`, `group_id`) VALUES ";

	for($i=0; $i < count($periods); $i++) {
		if($i > 0) $sql .= ",";

		$sql .= "(?, ?, ?, ?)";

		array_push($binding_values, $periods[$i]["date_from"]);
		array_push($binding_values, $periods[$i]["date_to"]);
		array_push($binding_values, $periods[$i]["count"]);
		array_push($binding_values, $group_id);

		$last_count = $periods[$i]["count"];
	}
	$sql .= "ON DUPLICATE KEY UPDATE `date_from` = VALUES(`date_from`), `date_to` = VALUES(`date_to`);";
	$sql .= ";";
	$req = $connect->prepare($sql);


	if($req->execute($binding_values)) {

		$sql = "DELETE FROM `nwty-periods` WHERE `group_id` = ? AND `count` > ?";
		$req = $connect->prepare($sql);
		
		if($req->execute(array($group_id, $last_count))) {
			$response = array("status" => "success", "text" => "Запись успешно сохранена");
		} else {
			$response = array("status" => "error", "text" => "Ошибка удаления старых записей");
		}

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

	return $data;

}




?>