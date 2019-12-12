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

	$sql_periods = "SELECT count, id FROM `nwyt_periods` WHERE group_id = ?";
	$req_per = $connect->prepare($sql_periods);
	$req_per->execute(array($group_id));
	$data_periods = $req_per->fetchAll();

	if(empty($data_periods)) {
		$response = array("status" => "error", "text" => "Отсутствуют периоды");
		die($response);
	}

	$sql_table_id = "INSERT INTO `nwyt_tables` (`group_id`) VALUES (?)";
	$req_id = $connect->prepare($sql_table_id);
	$responseID = $req_id->execute(array($group_id));
	$last_table_id = $connect->lastInsertId();


	$sql_cells = "INSERT INTO `nwyt_prices` (`value`, `row`, `table_id`, `period_id`) VALUES ";
	$binding_values = array();
	for($i=0; $i < count($data_periods); $i++) {
		if($i > 0) $sql_cells .= ",";

		$sql_cells .= "(?, ?, ?, ?)";

		$type = 1;

		array_push($binding_values, null);
		array_push($binding_values, $type);
		array_push($binding_values, $last_table_id);
		array_push($binding_values, $data_periods[$i]["id"]);
	}
	for($k=0; $k < count($data_periods); $k++) {
		$sql_cells .= ",";

		$sql_cells .= "(?, ?, ?, ?)";

		$type = 2;

		array_push($binding_values, null);
		array_push($binding_values, $type);
		array_push($binding_values, $last_table_id);
		array_push($binding_values, $data_periods[$k]["id"]);
	}
	$sql_cells .= ";";
	$req_cells = $connect->prepare($sql_cells);
	$responseCells = $req_cells->execute($binding_values);

	if($responseID && $responseCells) {

		$response = array("status" => "success", "text" => "Запись успешно сохранена");

	} else {

		$response = array("status" => "error", "text" => "Ошибка сохранения в Базу Данных");

	}

	header('Content-type: application/json');
	echo json_encode($response);

}


function getDataTable($group_id) {
	global $connect;

	if(!$group_id) {
		$response = array("status" => "error", "text" => "Нет идентификатора гостиницы");
		die($response);
	}

	 $sql	= "SELECT 
						 lt.table_id,
						 lt.period_id,
						 lt.period_count,
						 lt.date_from,
						 lt.date_to,
						 pp.value as price,
						 pp.row as table_row
	 				FROM

						(SELECT
								tt.id as table_id,
								prt.id as period_id,
								prt.count as period_count,
								prt.date_from,
								prt.date_to
							FROM nwyt_tables tt
								RIGHT JOIN nwyt_periods prt
								ON tt.group_id = prt.group_id
							WHERE tt.group_id = ?) as lt

						LEFT JOIN nwyt_prices pp
						 ON (lt.table_id = pp.table_id AND lt.period_id = pp.period_id )
											 
					ORDER BY lt.table_id";

	$req = $connect->prepare($sql);
	$req->execute(array($group_id));
	$data = $req->fetchAll();

	return(create_arrays_by($data));

}




?>