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

	require_once("./parts/form.php");

?>


<?php

	require_once("./parts/table.php");

?>

<!-- 
1. Добавить ответ в модели
2. Куки стартовая минимальная величина
3. При удачном ajax показать сохранено, также ошибка если
4. Короткие названия в базу
5. Вывод таблиц -->




<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="./app.js"></script>