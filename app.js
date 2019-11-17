
const currentYear = "2020";

// Конфиг для даты
const date_config = {
	enableTime: false,
	dateFormat: "Y-m-d",
	minDate: currentYear,
	onClose: function(selectedDates, dateStr, instance) {
		setMinDateParam(dateStr, instance);
		},
};

flatpickr.localize(flatpickr.l10ns.ru);



$(document).ready(function(){


	$("input[type=date]").not(".hidden input[type=date]").flatpickr(date_config);



});


/* Functions */
function addRow() {
	let lastCount = getDateCount();
	let baseRow = '<li class="price-room__period-item">' +
					'<div class="price-room__form">' +
						'<div class="price-room__group js-date-container">' +
							'<span class="price-room__group-text">с</span>' +
							'<input type="date" name="dateFrom" data-date-count='+(lastCount+1)+'>' +
						'</div>' +
						'<div class="price-room__group js-date-container">' +
							'<span class="price-room__group-text">по</span>' +
							'<input type="date" name="dateTo" data-date-count='+(lastCount+2)+'>' +
						'</div>' +
					'</div>' +
					'<a class="price-room__period-item-del js-delete-period" href="javascript:void(0);">' +
						'<span class="icon">' +
							'<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 20" enable-background="new 0 0 22 20" xml:space="preserve"><path fill="#C8C8C8" d="M18,1h-5c0-0.55-0.45-1-1-1h-2C9.45,0,9,0.45,9,1H4C3.45,1,3,1.45,3,2s0.45,1,1,1h14c0.55,0,1-0.45,1-1 S18.55,1,18,1z"></path><path fill="#C8C8C8" d="M16,4H6C4.9,4,4,4.9,4,6v12c0,1.1,0.9,2,2,2h10c1.1,0,2-0.9,2-2V6C18,4.9,17.1,4,16,4z M8,17 c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z M12,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1 s1,0.45,1,1V17z M16,17c0,0.55-0.45,1-1,1s-1-0.45-1-1V7c0-0.55,0.45-1,1-1s1,0.45,1,1V17z"></path></svg>' +
						'</span> Удалить' +
					'</a>' +
				'</li>"';

	let newRow = $(baseRow).appendTo("#price-room__period-list");

	newRow.find("input[type=date]").each(function() {
		$(this).flatpickr(date_config)
	});
}

function removeRow(button) {
	let listItem = button.closest(".price-room__period-item");
	updateDateCount(listItem.find("[data-date-count]").eq(0));
	listItem.remove();
}

function getDateCount() {
	const periodList = $("[data-date-count]");
	const countArr = [];
	
	periodList.each(function() {
		let countValue = $(this).attr("data-date-count");
		countArr.push(countValue);
	});

	return Math.max.apply(null, countArr)
}

function updateDateCount(deletedObj) {
	let deletedIndex = $(deletedObj).attr("data-date-count");

	$("[data-date-count]").each(function() {
		let dataIndex = $(this).attr("data-date-count");

		if(+dataIndex > +deletedIndex) {
			$(this).attr("data-date-count", +dataIndex-2);
		}
	});
}

function setMinDateParam(date, obj) {

}

/* Events */
$(document).on("click", ".js-add-period", function () {
	addRow();
});

$(document).on("click", ".js-delete-period", function () {
  removeRow($(this));
});
