<?php

require_once("./config.php");
require_once("./functions.php");


if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch($action) {
			case 'savePeriodData' : savePeriodData();
			break;
			case 'createTable'    : createTable();
			break;
			case 'saveTableData'  : saveTableData();
	}
}


function savePeriodData() {
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

function saveTableData() {
	global $connect;
	$response = array();

	//Отправляем новые значения для периодов дат в Базу Данных
	$tables = (isset($_POST["tables"])) ? json_decode($_POST["tables"], TRUE) : '';

	if (!is_array($tables)) {
		$response = array("status" => "error", "text" => "Неверный формат данных периодов");
		die($response);
	}

	$binding_values = array();

	$sql = "INSERT INTO `nwyt_prices` (`value`, `row_id`, `table_id`, `period_id`) VALUES ";


	for($i=0; $i < count($tables); $i++) {
		if($i > 0) $sql .= ",";

		$sql .= "(?, ?, ?, ?)";

		array_push($binding_values, $tables[$i]["value"]);
		array_push($binding_values, $tables[$i]["row_id"]);
		array_push($binding_values, $tables[$i]["table_id"]);
		array_push($binding_values, $tables[$i]["period_id"]);

	}

	$sql .= "ON DUPLICATE KEY UPDATE `value` = VALUES(`value`);";
	$req = $connect->prepare($sql);


	if($req->execute($binding_values)) {

		$response = array("status" => "success", "text" => "Запись успешно сохранена");

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


	$sql_cells = "INSERT INTO `nwyt_prices` (`value`, `row_id`, `table_id`, `period_id`) VALUES ";
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

	// Что просходит в запросе:
	// Первым делом мы создаем две таблицы. 
	// 1. Делаем выборку по всем строкам таблиц (у нас их две) и привязываем периоды по группе. Таблица ct1
	// 2. Делаем выборку по всем периодам и привязываем к ним все цены ( по id периода). Таблица ct2
	// Дальше связываем эти таблицы по периодам и строкам и таблицам
	 $sql	= "SELECT
							 ct1.table_id,
							 ct1.row_id,
							 ct1.row_text,
							 ct1.period_id,
							 ct1.date_from,
							 ct1.date_to,
							 ct1.period_count,
							 ct2.price,
							 ct2.price_row
					FROM
						(SELECT
								tt2.table_id,
								tt1.row_id,
								tt1.row_text,
								tt1.period_id,
								tt1.date_from,
								tt1.date_to,
								tt1.period_count
								FROM
									(SELECT
										trows.id as row_id,
										trows.text as row_text,
										tper.id as period_id,
										tper.date_from as date_from,
										tper.date_to as date_to,
										tper.count as period_count
										FROM nwyt_rows trows
										LEFT JOIN nwyt_periods tper
										ON 1 = 1
										WHERE tper.group_id = ? AND trows.id IN(1,2)
										ORDER BY trows.id
									) tt1
									LEFT JOIN
									(SELECT
											tt.id as table_id,
											tper.id as period_id,
											tper.count as period_count,
											tper.date_from,
											tper.date_to
											FROM nwyt_tables tt
											LEFT JOIN nwyt_periods tper
											ON tt.group_id = tper.group_id
											WHERE tper.group_id = ?  ORDER BY tt.id
										) tt2
									ON tt2.period_id = tt1.period_id
							) ct1

							LEFT JOIN

								 (SELECT
									 tprice.table_id,
									 tper.id as period_id,
									 tprice.value as price,
									 tprice.row_id as price_row
									 FROM
										nwyt_periods tper
									 LEFT JOIN nwyt_prices tprice
									 ON tper.id = tprice.period_id
									 WHERE tper.group_id = ?
								 ) ct2

							ON ct1.period_id = ct2.period_id AND ct1.table_id = ct2.table_id AND ct1.row_id = ct2.price_row
							ORDER BY ct1.table_id";

	$req = $connect->prepare($sql);
	$req->execute(array($group_id, $group_id, $group_id));
	$data = $req->fetchAll();

	return(create_arrays_by($data));
}


?>
