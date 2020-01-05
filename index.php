<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Neway02</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <!-- Inlude css -->
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">

</head>


<h1 class="main-heading">Динамическое добавление элементов</h1>

<?php

	require_once("./functions.php");
	require_once("./model.php");

?>

<?php

	require_once("./parts/form.php");

?>


<?php

	require_once("./parts/table.php");

?>


<button id="add_new_table" >Добавить таблицу</button>


<?php

/*
$date_now = date("Y-m-d");
$dataHeading = json_decode(getDataHeading(1), TRUE);


foreach($dataHeading as $date) {
	if(isBetweenDates(new Datetime($date_now), new Datetime($date["dateFrom"]["value"]), new Datetime($date["dateTo"]["value"]))) {

		print_r($date);

	}
}



<div class="current_date">
	Текущая дата - <?=$date_now;?> <br>
	Текущая цена - ТАКАЯ
</div>

*/
?>

<!-- 
- Куки стартовая минимальная величина
- аjax загрузка таблиц
- сохранение таблиц
- селект выбора гостинц
- динамика добавления таблицы для комнаты
- сравнение всей периодов и вывод нужно цены для каждой таблицы
- формирование общей таблицы
 -->


 <!-- 
- акция - поле для процента скидки
- таблица для кого применить (по гостиницам или номерам)
- где показывать или как показывать
 -->



<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="./app.js"></script>