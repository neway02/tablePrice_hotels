<?php

function isBetweenDates(DateTime $date, DateTime $date_start, DateTime $date_end) {
	return $date > $date_start && $date < $date_end;
}

function create_arrays_by($arr) {
	$date = array();
	$tables = array();
	$result = array();
	foreach($arr as $item) {

		$period_count = array(
			"period_id" 	=> $item['period_id'],
			"date_from" 	=> $item['date_from'],
			"date_to"			=> $item['date_to'],
			"price" 			=> $item['price'],
			"price_row" 	=> $item['price_row'],
			"price_text"	=> $item['row_text']
		);

		$period_info = array(
			"period_id" 	 => $item['period_id'],
			"date_from" 	 => $item['date_from'],
			"date_to"			 => $item['date_to'],
			"period_count" => $item['period_count']
		);


		$table = "table_".$item['table_id'];
		$row = "row_".$item['row_id'];
		$period ="period_".$item['period_count'];
		
		$tables[$table][$row][$period] = $period_count;

		$date[$period] = $period_info;

	}

	$result[0] = $date;
	$result[1] = $tables;

	return $result;
}


?>