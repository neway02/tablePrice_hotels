<?

// 12.12.19 Версия функции с возвратом всех записей цен по ключевому полю период
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

// То что получаем из Базы данных
// В новой версии порядок в массиве будет следующим Таблица -> Строка1, Строка2... -> Период1, Период2...
// В итоге получаем все строки из таблицы и все периоды даже если значений нет
// 	[table_22] => Array
//         (
//             [period_1] => Array
//                 (
//                     [row_1] => Array
//                         (
//                             [period_id] => 55
//                             [date_from] => 2019-12-09
//                             [date_to] => 2019-12-15
//                             [price] => 111
//                         )
//                 )
//             [period_2] => Array
//                 (
//                     [row_1] => Array
//                         (
//                             [period_id] => 56
//                             [date_from] => 2019-12-16
//                             [date_to] => 2019-12-22
//                             [price] => 1200
//                         )
//                     [row_2] => Array
//                         (
//                             [period_id] => 56
//                             [date_from] => 2019-12-16
//                             [date_to] => 2019-12-22
//                             [price] => 1500
//                         )
//                 )
//             [period_3] => Array
//                 (
//                     [row_] => Array
//                         (
//                             [period_id] => 57
//                             [date_from] => 2019-12-23
//                             [date_to] => 2019-12-29
//                             [price] => 
//                         )
//                 )
//         )
}


?>