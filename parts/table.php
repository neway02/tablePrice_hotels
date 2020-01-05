<?

$group_id = 1;


require_once("./model.php");

$data = getDataTable($group_id);

$data_head = $data[0];
$data_tables = $data[1];

?>

<div id="tables-container" class="tables-container">


	<?php	foreach ($data_tables as $id => $table) : ?>

		<?php
			$table_id_arr = explode("_", $id); 
			$table_id     = $table_id_arr[1];
		?>

		<div class="room-table" data-table-id="<?php echo $table_id; ?>">

				<?php 
				
				require("./parts/table_head.php");

				foreach($table as $row) :

					require("./parts/table_row.php");

				endforeach;
				
				?>

		</div>

	<?php endforeach; ?>

	<button id="button-tables-save">Сохранить</button>

</div>