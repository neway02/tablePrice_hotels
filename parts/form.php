<?php

require_once("./model.php");

$dataHeading = json_decode(getDataHeading(1), TRUE);

?>


<form id="prices_periods" method="post">
    <input type="hidden" name="hotel_id" value="">
    <ul id="price-room__period-list" class="price-room__period-list">

			<?php	if(!is_array($dataHeading) || empty($dataHeading)) : ?>

				<li class="price-room__period-item">
					<div class="price-room__form">
							<div class="price-room__group js-date-container">
									<span class="price-room__group-text">с</span>
									<input type="date" name="dateFrom" data-date-count=1 min="2020-01-01">
							</div>
							<div class="price-room__group js-date-container">
									<span class="price-room__group-text">по</span>
									<input type="date" name="dateTo" data-date-count=2 min="2020-01-01">
							</div>
					</div>
					<a class="price-room__period-item-del js-delete-period" href="javascript:void(0);">
							<span class="icon">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 20" enable-background="new 0 0 22 20" xml:space="preserve"><path fill="#C8C8C8" d="M18,1h-5c0-0.55-0.45-1-1-1h-2C9.45,0,9,0.45,9,1H4C3.45,1,3,1.45,3,2s0.45,1,1,1h14c0.55,0,1-0.45,1-1 S18.55,1,18,1z"></path><path fill="#C8C8C8" d="M16,4H6C4.9,4,4,4.9,4,6v12c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2V6C18,4.9,17.1,4,16,4z M8,17 c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z M12,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1 s1,0.45,1,1V17z M16,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z"></path></svg>
					</span>Удалить
					</a>
				</li>

				<?php else :

						foreach($dataHeading as $row) {

							$dateFrom = $row["dateFrom"];
							$dateTo = $row["dateTo"];

							?>

									<li class="price-room__period-item">
										<div class="price-room__form">
												<div class="price-room__group js-date-container">
														<span class="price-room__group-text">с</span>
														<input
															type="date"
															name="dateFrom"
															data-date-count=<?=$dateFrom["count"];?>
															min="<?=$dateFrom["min"];?>"
															value="<?=$dateFrom["value"];?>"
														>
												</div>
												<div class="price-room__group js-date-container">
														<span class="price-room__group-text">по</span>
														<input
															type="date"
															name="dateTo"
															data-date-count=<?=$dateTo["count"];?>
															min="<?=$dateTo["min"];?>"
															value="<?=$dateTo["value"];?>"
														>
												</div>
										</div>
										<a class="price-room__period-item-del js-delete-period" href="javascript:void(0);">
												<span class="icon">
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 20" enable-background="new 0 0 22 20" xml:space="preserve"><path fill="#C8C8C8" d="M18,1h-5c0-0.55-0.45-1-1-1h-2C9.45,0,9,0.45,9,1H4C3.45,1,3,1.45,3,2s0.45,1,1,1h14c0.55,0,1-0.45,1-1 S18.55,1,18,1z"></path><path fill="#C8C8C8" d="M16,4H6C4.9,4,4,4.9,4,6v12c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2V6C18,4.9,17.1,4,16,4z M8,17 c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z M12,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1 s1,0.45,1,1V17z M16,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z"></path></svg>
										</span>Удалить
										</a>
									</li>

							<?php

						}

				endif; ?>


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


<?php




?>