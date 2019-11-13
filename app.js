
const currentYear = "2020";

// Конфиг для даты
const date_config = {
	enableTime: false,
	dateFormat: "Y-m-d",
	minDate: currentYear,
  onClose: function(selectedDates, dateStr, instance) {
      
    },
};

flatpickr.localize(flatpickr.l10ns.ru);


$(document).ready(function(){


	$("input[type=date]").not(".hidden input[type=date]").flatpickr(date_config);



});


/* Variables */
let rowForm = $(".base-form .price-room__period-item");

/* Functions */
function addRow() {
	let newRow = rowForm.clone(true, true).appendTo("#price-room__period-list");
	newRow.find("input[type=date]").each(function() {
		$(this).flatpickr(date_config)
	});
}

function removeRow(button) {
	button.closest(".price-room__period-item").remove();
}

function validRangeDate() {

}

/* Events */
$(".js-add-period").on('click', function () {
	addRow();
});

$(".js-delete-period").on('click', function () {
  removeRow($(this));
});
