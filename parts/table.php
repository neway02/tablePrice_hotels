<?

$hotel_id = 1;
$room_id = 1;

require_once("./model.php");

$dataHeading = json_decode(getDataHeading($hotel_id), TRUE);


?>

<div id="tables-container" class="tables-container">
    <div class="room-table" data-room="2">
        <div class="room-table__row room-table__header blue">

						<div class="room-table__cell">
                Периоды
            </div>

						<?php	if(is_array($dataHeading) && !empty($dataHeading)) :

							foreach($dataHeading as $row) :

								$dateFrom = date("d.m", strtotime($row["dateFrom"]["value"]));
								$dateTo = date("d.m", strtotime($row["dateTo"]["value"]));
						
						?>

	            <div class="room-table__cell">
								<?php echo $dateFrom . "-" . $dateTo;?>
	            </div>

						<?php
	
							endforeach;

						endif;
						
						?>

        </div>
        <div class="room-table__row room-table__row-main">
            <div class="room-table__cell" data-title="Цена, ₽">
                За номер
						</div>
						
						<?php	if(is_array($dataHeading) && !empty($dataHeading)) :

								foreach($dataHeading as $row) :

									$dateFrom = date("d.m", strtotime($row["dateFrom"]["value"]));
									$dateTo = date("d.m", strtotime($row["dateTo"]["value"]));

								?>

									<div
										class="room-table__cell"
										data-title="<?php echo $dateFrom . "-" . $dateTo; ?>"
									>
			                <input class="table-input-date" type="text" value="">
			            </div>

								<?php

								endforeach;

								endif;

						?>

        </div>
        <div class="room-table__row room-table__row-sub">
            <div class="room-table__cell" data-title="Цена, ₽">
                За доп. место
						</div>
						
						<?php	if(is_array($dataHeading) && !empty($dataHeading)) :

							foreach($dataHeading as $row) :

								$dateFrom = date("d.m", strtotime($row["dateFrom"]["value"]));
								$dateTo = date("d.m", strtotime($row["dateTo"]["value"]));

							?>

								<div
									class="room-table__cell"
									data-title="<?php echo $dateFrom . "-" . $dateTo; ?>"
								>
										<input class="table-input-date" type="text" value="">
								</div>

							<?php

							endforeach;

							endif;

						?>

		</div>

	</div>



	<div class="bottom-container">
	     <button id="button-tables-save" class="button button-form button-tables-save">Сохранить</button>
	</div>
</div>