
const currentYear = "2020-01-01";
let datePickers = [];



$(document).ready(function(){


	//

	// [
	// 	{"dateFrom" : "x1", "dateTo" : "y1"},
	// 	{"dateFrom" : "x2", "dateTo" : "y2"},
	// 	{"dateFrom" : "x3", "dateTo" : "y3"}
	// ];



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

	setMinDateParam($(`[data-date-count=${lastCount}]`));
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

function findDateValue(obj) {
	let dateString = '';
	let firstCall = $(obj).closest(".price-room__group");
	let prevNode = '';

	debugger

	prevNode = firstCall.prev(".price-room__group");

	if (prevNode.length > 0) {
		let prevDate = prevNode.find("[data-date-count]");
		if(prevDate.val()) {
			dateString = prevDate.val();
		} else {
			dateString = findDateValue(prevDate);
		}
	} else {
		let prevGroup = firstCall.closest(".price-room__period-item").prev(".price-room__period-item");
		
		if(prevGroup.length > 0) {
			let nextCall = prevGroup.find(".price-room__group").last();
			let nextDate = nextCall.find("[data-date-count]");
			if(nextDate.val()) {
				dateString = nextDate.val();
			} else {
				dateString = findDateValue(nextDate);
			}
		} else {
			dateString = '';
		}
	}
	return dateString;
}

function setMinDateParam(obj) {

	// Правильный формат даты 2019-11-02
	let objIndex = $(obj).attr("data-date-count");
	let objValue = {};
	
	if(!$(obj).val()) {
		objValue = new Date(findDateValue(obj));
	} else {
		objValue = new Date($(obj).val());
	}

	let nextDate = new Date(objValue.getTime() + (24 * 60 * 60 * 1000));

	let objYear = nextDate.getUTCFullYear();
	let objMonth = nextDate.getUTCMonth() + 1;
	let objDay = nextDate.getUTCDate();

	//Проверяем на корректность формата даты (dd, mm)
	if (objDay && objDay < 10) {
		objDay = '0' + objDay;
	  } 
	if (objMonth && objMonth < 10) {
		objMonth = '0' + objMonth;
	} 
	
	let newDate = objYear + "-" + objMonth + "-" + objDay;

	$("[data-date-count]").each(function() {
		let dataIndex = $(this).attr("data-date-count");

		if(+dataIndex > +objIndex) {
			$(this).attr("min", newDate);

			let eachValue = $(this).val();

			if(eachValue) {
				let eachDate = new Date(eachValue);
				if(eachDate <= nextDate) {
					$(this).val("");
				}
			}
		}
	});
}

/* Events */
$(document).on("click", ".js-add-period", function() {
	addRow();
});

$(document).on("click", ".js-delete-period", function() {
  removeRow($(this));
});

$(document).on("change", "[data-date-count]", function() {
  setMinDateParam($(this));
});

$(document).on("submit", "#prices_periods", function(e) {
	e.preventDefault();
	let data = [];
	$("#prices_periods").find(".price-room__period-item").each(function() {
		let dateObj = {};

		$(this).find("[data-date-count]").each(function() {
			if($(this).val()) {
				Object.assign(dateObj, {[$(this).attr("name")]: $(this).val()});
			}
		});

		data.push(dateObj);
	});

	console.log(data);
});