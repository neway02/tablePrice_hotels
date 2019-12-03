<?php

function isBetweenDates(DateTime $date, DateTime $date_start, DateTime $date_end) {
	return $date > $date_start && $date < $date_end;
}


function pdoMultiInsert($tableName, $data, $pdoObject){
	 
	 //Will contain SQL snippets.
	 $rowsSQL = array();

	 //Will contain the values that we need to bind.
	 $toBind = array();
	 
	 //Get a list of column names to use in the SQL statement.
	 $columnNames = array_keys($data[0]);

	 //Loop through our $data array.
	 foreach($data as $arrayIndex => $row){
			 $params = array();
			 foreach($row as $columnName => $columnValue){
					 $param = ":" . $columnName . $arrayIndex;
					 $params[] = $param;
					 $toBind[$param] = $columnValue; 
			 }
			 $rowsSQL[] = "(" . implode(", ", $params) . ")";
	 }

	 //Construct our SQL statement
	 $sql = "INSERT INTO `$tableName` (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);

	 //Prepare our PDO statement.
	 $pdoStatement = $pdoObject->prepare($sql);

	 //Bind our values.
	 foreach($toBind as $param => $val){
			 $pdoStatement->bindValue($param, $val);
	 }
	 
	 //Execute our statement (i.e. insert the data).
	 return $pdoStatement->execute();
}



?>