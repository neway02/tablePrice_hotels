<?php

function isBetweenDates(DateTime $date, DateTime $date_start, DateTime $date_end) {
	return $date > $date_start && $date < $date_end;
}



?>