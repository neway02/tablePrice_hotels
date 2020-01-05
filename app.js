
const currentYear = "2020-01-01";
let datePickers = [];


function isNumber(value) {
	if(value instanceof Number)
		value = value.valueOf();

		return isFinite(value) && value === parseInt(value, 10);
}


$(document).ready(function(){


	//


});

$(document).on("click", ".form_notify", function() {
	$(this).addClass('animate-reverse');
	setTimeout(function() {
		$(this).remove();
	}, 5000);
});

/* Functions */
function notifyShow(obj, type, text) {

	obj.css("position", "relative");

	$("<div class=\"form_notify animate\"></div>").appendTo(obj).addClass(type).text(text);
	let elem = obj.find(".form_notify");

	setTimeout(function() {
		elem.addClass('animate-reverse');
	}, 1600);

	setTimeout(function() {
		elem.remove();
	}, 4000);
}


function addRow() {
	let lastCount = getDateCount();
	lastCount = isNumber(lastCount) ? lastCount : 0;

	let baseRow = '<li class="price-room__period-item" data-date-count=' + (lastCount + 1) + '>' +
					'<div class="price-room__form">' +
						'<div class="price-room__group js-date-container">' +
							'<span class="price-room__group-text">с</span>' +
							'<input type="date" name="date_from">' +
						'</div>' +
						'<div class="price-room__group js-date-container">' +
							'<span class="price-room__group-text">по</span>' +
							'<input type="date" name="date_to">' +
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
	let listItemIndex = listItem.attr("data-date-count");
	let listItemDate = listItem.find("[type=date]").eq(0);

	updateIndexCount(listItem);
	listItem.remove();

	let lastListIndex = $(`[data-date-count = ${listItemIndex-1}]`);


	if(lastListIndex.length > 0) {
		setMinDateParam(lastListIndex);
	} else {
		let lastList = $(`[data-date-count = ${listItemIndex}]`);
		let lastListDateValue = lastList.find("[name=date_from]").val();

		if(!lastListDateValue) {
			lastList.find("[name=date_from]").val(currentYear).attr("min", currentYear);
		}

		setMinDateParam(lastList);
	}

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

function updateIndexCount(deletedObj) {
	let deletedIndex = $(deletedObj).attr("data-date-count");
	$("[data-date-count]").each(function() {
		let dataIndex = $(this).attr("data-date-count");

		if(+dataIndex > +deletedIndex) {
			$(this).attr("data-date-count", +dataIndex-1);
		}
	});
}

function findDateValue(obj) {
	let dateString = '';
	let firstCall = $(obj).closest(".price-room__group");
	let prevNode = '';

	prevNode = firstCall.prev(".price-room__group");

	if (prevNode.length > 0) {
		let prevDate = prevNode.find("[type=date]");
		if(prevDate.val()) {
			dateString = prevDate.val();
		} else {
			dateString = findDateValue(prevDate);
		}
	} else {
		let prevGroup = firstCall.closest(".price-room__period-item").prev(".price-room__period-item");
		
		if(prevGroup.length > 0) {
			let nextCall = prevGroup.find(".price-room__group").last();
			let nextDate = nextCall.find("[type=date]");
			if(nextDate.val()) {
				dateString = nextDate.val();
			} else {
				dateString = findDateValue(nextDate);
			}
		} else {
			dateString = currentYear;
		}
	}
	return dateString;
}

function setMinDateParam(obj) {

	// Правильный формат даты 2019-11-02
	let objIndex = $(obj).attr("data-date-count");
	let dateObj = '';
	let fromDateClicked = false;

	let fromDate = obj.find("[name=date_from]");
	let toDate = obj.find("[name=date_to]");
	let formDateValue = fromDate.val();
	let toDateValue = toDate.val();

	if(formDateValue && formDateValue >= toDateValue) {
		dateObj = fromDate;
		fromDateClicked = true;
	} else {
		dateObj = toDate;
	}

	let objValue = {};

	if(!$(dateObj).val()) {
		objValue = new Date(findDateValue(dateObj));
	} else {
		objValue = new Date($(dateObj).val());
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

	if (fromDateClicked) {
		toDate.val("").attr("min", newDate);
	}

	$("[data-date-count]").each(function() {
		let dataIndex = $(this).attr("data-date-count");

		if(+dataIndex > +objIndex) {
			let validList = $(this);
			validList.find("[type=date]").each(function() {
				let eachValue = $(this).val();
				if(eachValue) {
					let eachDate = new Date(eachValue);
					if(eachDate <= nextDate) {
						$(this).val("");
						$(this).attr("min", newDate);
					} else {
						return false;
					}
				} else {
					$(this).attr("min", newDate);
				}
			});
		}
	});
}

function addTable() {

	form = $("#tables-container");

	$.ajax({
		method: "POST",
		url: "./model.php",
		data: {
			"group_id" : "1",
			"action" : "createTable"
		},
		success: function(data) {

			responseText = "";
			responseType = "";

			if(data.status) {
				responseText = data.text;
				responseType = data.status;
			 } else {
				responseText = data ? data : "Неизвестная ошибка";
				responseType = "error";
			}

			notifyShow(form, responseType, responseText);

		},
		error: function(data, errorThrown) {
       alert('request failed : '+ errorThrown);
    }
	})
}

/* Events */
$(document).on("click", ".js-add-period", function() {
	addRow();
});

$(document).on("click", ".js-delete-period", function() {
  removeRow($(this));
});

$(document).on("change", "[type=date]", function() {
	let periodList = $(this).closest("[data-date-count]");
  setMinDateParam(periodList);
});

$(document).on("click", "#add_new_table", function() {
  addTable();
});



$(document).on("submit", "#prices_periods", function(e) {
	e.preventDefault();
	let dataPeriod = [];
	let error = false;
	let form = $(this);

	$("#prices_periods").find("[type=date]").each(function() {
		let dateValue = $(this).val();
		if (!dateValue) {
				alert("Заполните все поля. Отсутствует поле в строке № " + $(this).closest("[data-date-count]").attr("data-date-count"));
				error = true;
				return false;
			}
	});

	if (error) return false;

	$("#prices_periods").find("[data-date-count]").each(function() {
		
		let date_from = $(this).find("[name=date_from]").val();
		let date_to = $(this).find("[name=date_to]").val();
		let count = $(this).attr("data-date-count");
	
		let dateObj = {
			date_from,
			date_to,
			count
		};

		dataPeriod.push(dateObj);
	});

	if(error) {
		return false;
	}

	$.ajax({
		method: "POST",
		url: "./model.php",
		data: {
			"periods" : JSON.stringify(dataPeriod),
			"group_id" : "1",
			"action" : "savePeriodData"
		},
		success: function(data) {

			responseText = "";
			responseType = "";

			console.log(data);

			if(data.status) {
				responseText = data.text;
				responseType = data.status;
			 } else {
				responseText = data ? data : "Неизвестная ошибка";
				responseType = "error";
			}

			notifyShow(form, responseType, responseText);

		},
		error: function(data, errorThrown) {
       alert('request failed : '+ errorThrown);
    }
	})
});


$(document).on("click", "#button-tables-save", function() {

	let data_table = [];
	let container = $("#tables-container");
	let error = false;

	container.find(".room-table").each(function() {
		
		if (error) return false;

		table_id = $(this).attr("data-table-id");

		let table_rows = $(this).find(".room-table__row-body");

		table_rows.each(function(index) {

			let table_row = $(this);
			let table_row_index = index+1;

			table_row.find(".table-input-date").each(function() {

				let tableObj  = {};
				let value     = $(this).val();
				let period_id = $(this).attr("data-period-id");

				if(value == '') {
					value = 0;
				}

				value = parseInt(value);

				if(isNumber(value)) {

						if(value > 0) {

							tableObj = Object.assign(tableObj, {
								"table_id"  : table_id,
								"period_id" : period_id,
								"row_id"    : table_row_index,
								"value"     : value
							});

							data_table.push(tableObj);

						}

				} else {
						error = true;
						alert("В таблице допускаются только числовые значения");
						console.log("error", value);
						console.log("error", isNumber(value));
				}
	
				if (error) return false;

			});
		});
	});

	if (error) return false;

	$.ajax({
		method: "POST",
		url: "./model.php",
		data: {
			"tables" : JSON.stringify(data_table),
			"action" : "saveTableData"
		},
		success: function(data) {

			responseText = "";
			responseType = "";

			console.log(data);

			if(data.status) {
				responseText = data.text;
				responseType = data.status;
			 } else {
				responseText = data ? data : "Неизвестная ошибка";
				responseType = "error";
			}

			notifyShow(container, responseType, responseText);

		},
		error: function(data, errorThrown) {
       alert('request failed : '+ errorThrown);
    }
	})

});
