<div class="room-table__row room-table__header blue">


<div class="room-table__cell">
		Периоды
</div>

	<?php	foreach($data_head as $dates) :

		$dateFrom = date("d.m", strtotime($dates["date_from"]));
		$dateTo = date("d.m", strtotime($dates["date_to"]));

	?>

	<div class="room-table__cell">
		<?php echo $dateFrom . "-" . $dateTo;?>
	</div>

	<?php	endforeach;	?>

</div>