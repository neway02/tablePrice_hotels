<?

$group_id = 1;
$room_id = 1;

require_once("./model.php");

$data_tables = getDataTable($group_id);

echo "<pre>";
print_r($data_tables);
echo "</pre>";

?>

<div id="tables-container" class="tables-container">


	<?php	foreach ($data_tables as $id => $data) : ?>

		<?php $id = explode("_", $id); ?>

		<div class="room-table" data-table-id="<?php echo $id[1]; ?>">
        <div class="room-table__row room-table__header blue">

						<div class="room-table__cell">
                Периоды
            </div>

						<?php	foreach($data as $row) :


								$dateFrom = date("d.m", strtotime($row["date_from"]));
								$dateTo = date("d.m", strtotime($row["date_to"]));
						
						?>

	            <div class="room-table__cell">
								<?php echo $dateFrom . "-" . $dateTo;?>
	            </div>

						<?php	endforeach;	?>

				</div>
				
        <div class="room-table__row room-table__row-main">
            <div class="room-table__cell" data-title="Цена, ₽">
                За номер
						</div>
						
						<?php	foreach($data as $row) :

									$dateFrom = date("d.m", strtotime($row["date_from"]));
									$dateTo = date("d.m", strtotime($row["date_to"]));
									$price = isset($row["price"]) && !empty($row["price"]) ? $row["price"] : '';

								?>

									<div
										class="room-table__cell"
										data-title="<?php echo $dateFrom . "-" . $dateTo; ?>"
									>
			                <input class="table-input-date" type="text" value="<?php echo $price; ?>">
			            </div>

						<?php	endforeach; ?>

        </div>
        <div class="room-table__row room-table__row-sub">
            <div class="room-table__cell" data-title="Цена, ₽">
                За доп. место
						</div>
						
						<?php	foreach($data as $row) :

							$dateFrom = date("d.m", strtotime($row["date_from"]));
							$dateTo = date("d.m", strtotime($row["date_to"]));
							$price = isset($row["price"]) && !empty($row["price"]) ? $row["price"] : '';

							?>

							<div
								class="room-table__cell"
								data-title="<?php echo $dateFrom . "-" . $dateTo; ?>"
							>
									<input class="table-input-date" type="text" value="<?php echo $price; ?>">
							</div>

						<?php	endforeach; ?>
        </div>

		</div>


	<?php endforeach; ?>

</div>