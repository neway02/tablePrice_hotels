<?php

function isBetweenDates(DateTime $date, DateTime $date_start, DateTime $date_end) {
	return $date > $date_start && $date < $date_end;
}

function create_arrays_by($arr) {
	$result = array();
	foreach($arr as $item) {

		$period_count = array(
			"period_id" => $item['period_id'],
			"date_from" => $item['date_from'],
			"date_to" => $item['date_to'],
			"price" => $item['price']
		);

		$table = "table_".$item['table_id'];
		$period ="period_".$item['period_count'];
		$type = "row_".$item['table_row'];


		$result[$table][$period][$type] = $period_count;

	}
	return $result;
}


?>