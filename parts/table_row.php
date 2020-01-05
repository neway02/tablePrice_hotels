<div class="room-table__row room-table__row-body">


    <div class="room-table__cell" data-title="Цена, ₽">
				<?php
					$first = current($row); // Номер один
					echo $first["price_text"]; 
				?>
		</div>
		
		<?php	foreach($row as $period) :

					$dateFrom = date("d.m", strtotime($period["date_from"]));
					$dateTo = date("d.m", strtotime($period["date_to"]));
					$price = isset($period["price"]) && !empty($period["price"]) ? $period["price"] : 0;
					$period_id = isset($period["period_id"]) && !empty($period["period_id"]) ? $period["period_id"] : 0;

				?>

					<div
						class="room-table__cell"
						data-title="<?php echo $dateFrom . "-" . $dateTo; ?>"
					>
							<input
								class="table-input-date"
								type="text"
								value="<?php echo $price; ?>"
								data-period-id="<?php echo $period_id; ?>"
							>
          </div>

		<?php	endforeach; ?>

</div>