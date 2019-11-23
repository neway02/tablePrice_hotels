﻿<!DOCTYPE html>
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

<form id="prices_periods" method="post">
    <input type="hidden" name="hotel_id" value="">
    <ul id="price-room__period-list" class="price-room__period-list">
        <li class="price-room__period-item">
            <div class="price-room__form">
                <div class="price-room__group js-date-container">
                    <span class="price-room__group-text">с</span>
                    <input type="date" name="dateFrom" data-date-count=1>
                </div>
                <div class="price-room__group js-date-container">
                    <span class="price-room__group-text">по</span>
                    <input type="date" name="dateTo" data-date-count=2>
                </div>
            </div>
            <a class="price-room__period-item-del js-delete-period" href="javascript:void(0);">
                <span class="icon">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 20" enable-background="new 0 0 22 20" xml:space="preserve"><path fill="#C8C8C8" d="M18,1h-5c0-0.55-0.45-1-1-1h-2C9.45,0,9,0.45,9,1H4C3.45,1,3,1.45,3,2s0.45,1,1,1h14c0.55,0,1-0.45,1-1 S18.55,1,18,1z"></path><path fill="#C8C8C8" d="M16,4H6C4.9,4,4,4.9,4,6v12c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2V6C18,4.9,17.1,4,16,4z M8,17 c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z M12,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1 s1,0.45,1,1V17z M16,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z"></path></svg>
				</span>Удалить
            </a>
        </li>
    </ul>
    <div class="bottom-container">
        <div class="price-room__link-block">
            <a class="price-room__link js-add-period" href="javascript:void(0);">
                <span class="icon-plus"></span>Добавить период
            </a>
        </div>
        <button class="button button-form">Сохранить</button>
    </div>
</form>


<div class="tables-container">
    <div class="room-table">
        <div class="room-table__row room-table__header blue">
            <div class="room-table__cell">
                Периоды
            </div>
            <div class="room-table__cell">
                01.06 - 14.06
            </div>
            <div class="room-table__cell">
                17.06 - 15.07
            </div>
            <div class="room-table__cell">
                16.07 - 1.09
            </div>
        </div>
        <div class="room-table__row">
            <div class="room-table__cell" data-title="Цена">
                За номер, ₽
            </div>
            <div class="room-table__cell" data-title="01.06 - 14.06">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="17.06 - 15.07">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="16.07 - 1.09">
                <input type="text">
            </div>
        </div>
        <div class="room-table__row">
            <div class="room-table__cell" data-title="Цена">
                За доп. место, ₽
            </div>
            <div class="room-table__cell" data-title="Email">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="Password">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="Active">
                <input type="text">
            </div>
        </div>
    </div>

    <div class="room-table">
        <div class="room-table__row room-table__header green">
            <div class="room-table__cell">
                Периоды
            </div>
            <div class="room-table__cell">
                01.06 - 14.06
            </div>
            <div class="room-table__cell">
                17.06 - 15.07
            </div>
            <div class="room-table__cell">
                16.07 - 1.09
            </div>
        </div>
        <div class="room-table__row">
            <div class="room-table__cell" data-title="Цена">
                За номер, ₽
            </div>
            <div class="room-table__cell" data-title="01.06 - 14.06">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="17.06 - 15.07">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="16.07 - 1.09">
                <input type="text">
            </div>
        </div>
        <div class="room-table__row">
            <div class="room-table__cell" data-title="Цена">
                За доп. место, ₽
            </div>
            <div class="room-table__cell" data-title="Email">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="Password">
                <input type="text">
            </div>
            <div class="room-table__cell" data-title="Active">
                <input type="text">
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="./app.js"></script>