<?

require_once("./model.php");

$dataHeading = json_decode(getDataHeading(1), TRUE);


?>

<div class="tables-container">
    <div class="room-table">
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



<?php











?>