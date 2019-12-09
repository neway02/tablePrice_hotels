<?php

require_once("./config.php");
require_once("./functions.php");


if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
			case 'saveHeadData' : saveHeadData();
			break;
			case 'createTable' : createTable();
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

	$sql = "INSERT INTO `nwyt_periods` (`date_from`, `date_to`, `count`, `group_id`) VALUES ";

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

		$sql = "DELETE FROM `nwyt_periods` WHERE `group_id` = ? AND `count` > ?";
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


function createTable() {
	global $connect;
	$response = array();

	//Отправляем новые значения для периодов дат в Базу Данных
	$group_id = (isset($_POST["group_id"])) ? $_POST["group_id"] : false;

	if(!$group_id) {
		$response = array("status" => "error", "text" => "Нет идентификатора гостиницы");
		die($response);
	}

	$sql = "INSERT INTO `nwyt_tables` (`group_id`) VALUES (?)";
	$req = $connect->prepare($sql);

	if($req->execute(array($group_id))) {

		$response = array("status" => "success", "text" => "Запись успешно сохранена");

	} else {

		$response = array("status" => "error", "text" => "Ошибка сохранения в Базу Данных");

	}

	header('Content-type: application/json');
	echo json_encode($response);

}


function create_arrays_by($arr) {
	$result = array();
	foreach($arr as $item) {

		$period_count = array(
			"period_id" => $item['period_id'],
			"date_from" => $item['date_from'],
			"date_to" => $item['date_to'],
			"type" => $item['type'],
			"price" => $item['price']
		);

		$result["table_".$item['table_id']]["period_".$item['period_count']] = $period_count;

	}
	return $result;
}


function getDataTable($group_id) {
	global $connect;

	if(!$group_id) {
		$response = array("status" => "error", "text" => "Нет идентификатора гостиницы");
		die($response);
	}

	 $sql	= "SELECT
						tt.group_id,
            tt.id as table_id,
            prt.id as period_id,
            prt.count as period_count,
            prt.date_from,
				    prt.date_to,
            pt.value as price,
            pt.type
					FROM nwyt_tables tt
              	LEFT JOIN nwyt_periods prt
		            ON tt.group_id = prt.group_id
                          
                LEFT JOIN nwyt_prices pt
		            ON prt.id = pt.period_id
					WHERE tt.group_id = ?";

	$req = $connect->prepare($sql);
	$req->execute(array($group_id));
	$data = $req->fetchAll();


	return(create_arrays_by($data));

	return $data;

}




?>