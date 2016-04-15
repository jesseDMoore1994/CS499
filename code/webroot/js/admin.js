
var ticketDialog, customerDialog, performanceDialog, seasonDialog;
var sectionDialog, rowDialog, seatDialog;
var seatEditor, rowEditor, sectionEditor;

$(document).ready(function() {

	ticketDialog = createDialog(".ticket-creator", 520, saveTicket);
	customerDialog = createDialog(".customer-creator", 520, saveCustomer);
	performanceDialog = createDialog(".performance-creator", 520, savePerformance);
	seasonDialog = createDialog(".seasons-creator", 520, saveSeason);
	sectionDialog = createDialog(".section-creator", 520, createSection);
	rowDialog = createDialog(".row-creator", 450, createRow);
	seatDialog = createDialog(".seat-creator", 300, saveSeat);
	sectionEditor = createDeleteDialog(".section-editor", 300, editSection, deleteSection);
	rowEditor = createDeleteDialog(".row-editor", 225, editRow, deleteRow);
	seatEditor = createDeleteDialog(".seat-editor", 300, editSeat, deleteSeat);

	initTicketDialog();
	initCustomerDialog();
	initTheaterSwitcher();

	$( ".datepicker" ).datepicker();

});

function createDialog(selector, height, callback) {
	var dialog = $(selector).dialog({
		autoOpen: false,
		height: height,
		width: 600,
		modal: true,
		buttons: {
			"Save Changes": function() {
				callback();
			},
			Cancel: function() {
				dialog.dialog( "close" );
			}
		},
		close: function() {
			$(".dialog-form")[0].reset();
		}
	});
	return dialog;
}

function createDeleteDialog(selector, height, callback, deleteCallback) {
	var dialog = $(selector).dialog({
		autoOpen: false,
		height: height,
		width: 600,
		modal: true,
		buttons: {
			"Save Changes": function() {
				callback();
			},
			"Delete": function() {
				if (confirm("Are you sure you want to delete this item?")) {
					deleteCallback();
				}
			},
			Cancel: function() {
				dialog.dialog( "close" );
			}
		},
		close: function() {
			$(".dialog-form")[0].reset();
		}
	});
	return dialog;
}


function initTicketDialog() {
	$("#ticket-creator-payment").hide();

	$("#ticket-creator-payment-select").change(function() {
		if ($(this).val() == "paid-credit") {
			$("#ticket-creator-payment").show();
		} else {
			$("#ticket-creator-payment").hide();
		}
	})
}



function showTicketDialog() {
	ticketDialog.dialog( "open" );
}

function showTicketEditDialog(id) {
	ticketDialog.dialog( "open" );

	json = JSON.parse($("#ticket-"+id+" .data").text());
	$(".ticket-creator .full-name").val(json["person_name"]);
	$(".ticket-creator #ticket-creator-payment-select").val(json["payment_status_value"]);
}

function createTicket() {
	
}

function saveTicket() {

}



function initCustomerDialog() {
	$("#customer-creator-changepasswordoptions").hide();

	$("#customer-creator-changepassword").change(function() {
		if ($(this).val() == "0") {
			$("#customer-creator-changepasswordoptions").hide();
		} else {
			$("#customer-creator-changepasswordoptions").show();
		}

	});
}

function showCustomerDialog(staff) {
	customerDialog.dialog( "open" );
	$(".customer-creator-edit").hide();
	$(".customer-creator-new").show();
	$(".customer-creator").attr("data-customer", 0);

	if (staff) {
		$("#access-level[value=0]").hide();
	} else {
		$("#access-level[value=0]").show();
	}
}

function showCustomerEditDialog(staff, id) {
	customerDialog.dialog( "open" );
	$(".customer-creator-edit").show();
	$(".customer-creator-new").hide();
	$("#customer-creator-changepasswordoptions").hide();
	$(".customer-creator").attr("data-customer", id);

	if (staff) {
		$("#access-level[value=0]").hide();
	} else {
		$("#access-level[value=0]").show();
	}

	json = JSON.parse($("#customer-"+id+" .data").text());
	$(".customer-creator .customer-name").val(json["name"]);
	$(".customer-creator .customer-email").val(json["email"]);
	$(".customer-creator .access-level").val(json["access_level"]);
}

function saveCustomer() {
	var base = $("body").attr("data-urlbase");
	var edit = $(".customer-creator").attr("data-customer");

	var data = {
		name: $(".customer-creator .customer-name").val(),
		email: $(".customer-creator .customer-email").val(),
		access_level: $(".customer-creator .access-level").val(),
		password: $(".customer-creator .password").val(),
		password_confirm: $(".customer-creator .password_confirm").val()
	};

	$.ajax({
		method: "POST",
		url: base + "admin/customers/api_manage/"+((edit == 0) ? "" : edit),
		data: data,
		success: function() {
			location.reload();
		},
		error: function(xhr, status, error) {
			//$("body").html(xhr.responseText);
			alert("Could not save.");
		}
	});
}



function showPerformanceDialog() {
	performanceDialog.dialog( "open" );
	$(".performance-creator").attr("data-performance", 0);
}

function showPerformanceEditDialog(id) {
	performanceDialog.dialog( "open" );
	$(".performance-creator").attr("data-performance", id);

	json = JSON.parse($("#performance-"+id+" .data").text());
	$(".performance-creator .date").val(json["performance_date"]);
	$(".performance-creator .time").val(json["performance_hour"]);
	$(".performance-creator .season").val(json["performance_season"]);
	$(".performance-creator .open").val(json["performance_open"]);
	$(".performance-creator .canceled").val(json["performance_canceled"]);
}

function savePerformance() {
	var base = $("body").attr("data-urlbase");
	var edit = $(".performance-creator").attr("data-performance");

	var data = {
		play: $(".performance-creator .play").val(),
		date: $(".performance-creator .date").val(),
		time: $(".performance-creator .time").val(),
		season: $(".performance-creator .season").val(),
		open: $(".performance-creator .open").val(),
		canceled: $(".performance-creator .canceled").val()
	};

	$.ajax({
		method: "POST",
		url: base + "admin/schedule/api_manage/"+((edit == 0) ? "" : edit),
		data: data,
		success: function() {
			location.reload();
		},
		error: function(xhr, status, error) {
			//$("body").html(xhr.responseText);
			alert("Could not create performance.");
		}
	});
}



function initTheaterSwitcher() {
	$(".admin-theater-switcher").change(function() {
		urlbase = $("body").attr("data-urlbase");
		window.location = urlbase + "admin/settings/select/" + $(this).val() + "/";
	});
}



function showSeasonDialog() {
	seasonDialog.dialog( "open" );
	$(".seasons-creator").attr("data-season", "0");
}

function showSeasonEditDialog(id) {
	seasonDialog.dialog( "open" );
	$(".seasons-creator").attr("data-season", id);

	json = JSON.parse($("#season-"+id+" .data").text());
	$(".seasons-creator .name").val(json["name"]);
	$(".seasons-creator .start").val(json["start"]);
	$(".seasons-creator .end").val(json["end"]);
	$(".seasons-creator .price").val(json["price"]);
}

function saveSeason() {
	var base = $("body").attr("data-urlbase");
	var edit = $(".seasons-creator").attr("data-season");

	var data = {
		name: $(".seasons-creator .name").val(),
		start: $(".seasons-creator .start").val(),
		end: $(".seasons-creator .end").val(),
		price: $(".seasons-creator .price").val()
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_season_manage/"+((edit == 0) ? "" : edit),
		data: data,
		success: function() {
			location.reload();
		},
		error: function(xhr, status, error) {
			//$("body").html(xhr.responseText);
			alert("Could not create season.");
		}
	});
}



function showSectionDialog() {
	sectionDialog.dialog( "open" );
	$(".section-creator").attr("data-section", "0");
}

function createSection() {
	var base = $("body").attr("data-urlbase");

	var data = {
		name: $(".section-creator .name").val(),
		rows: $(".section-creator .rows").val(),
		seats: $(".section-creator .seats").val(),
		code: $(".section-creator .code").val(),
		price: $(".section-creator .price").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_create_section/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function showRowDialog(section) {
	rowDialog.dialog( "open" );
	$(".row-creator").attr("data-section", section);
}

function showSeatDialog(section, row) {
	seatDialog.dialog( "open" );
	$(".seat-creator").attr("data-section", section);
	$(".seat-creator").attr("data-row", row);
}

function showRowEditorDialog(row, code) {
	rowEditor.dialog("open");
	$(".row-editor").attr("data-row", row);

	$(".row-editor .code").val(code);
}

function showSeatEditorDialog(seat, price, code) {
	seatEditor.dialog("open");
	$(".seat-editor").attr("data-seat", seat);

	$(".seat-editor .code").val(code);
	$(".seat-editor .price").val(price);
}

function showSectionEditorDialog(section, name, code) {
	sectionEditor.dialog("open");
	$(".section-editor").attr("data-section", section);

	$(".section-editor .name").val(name);
	$(".section-editor .code").val(code);
}

function saveSeat() {
	var section = $(".seat-creator").attr("data-section");
	var row = $(".seat-creator").attr("data-row");
	var base = $("body").attr("data-urlbase");

	var data = {
		section: section,
		row: row,
		code: $(".seat-creator .code").val(),
		price: $(".seat-creator .price").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_create_seat/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function createRow() {
	var section = $(".row-creator").attr("data-section");
	var base = $("body").attr("data-urlbase");

	var data = {
		section: section,
		seats: $(".row-creator .seats").val(),
		code: $(".row-creator .code").val(),
		price: $(".row-creator .price").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_create_row/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function saveSeat() {
	var section = $(".seat-creator").attr("data-section");
	var row = $(".seat-creator").attr("data-row");
	var base = $("body").attr("data-urlbase");

	var data = {
		section: section,
		row: row,
		code: $(".seat-creator .code").val(),
		price: $(".seat-creator .price").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_create_seat/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function editSection() {
	var section = $(".section-editor").attr("data-section");
	var base = $("body").attr("data-urlbase");

	var data = {
		section: section,
		code: $(".section-editor .code").val(),
		name: $(".section-editor .name").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_edit_section/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function editRow() {
	var row = $(".row-editor").attr("data-row");
	var base = $("body").attr("data-urlbase");

	var data = {
		row: row,
		code: $(".row-editor .code").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_edit_row/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function editSeat() {
	var seat = $(".seat-editor").attr("data-seat");
	var base = $("body").attr("data-urlbase");

	var data = {
		seat: seat,
		code: $(".seat-editor .code").val(),
		price: $(".seat-editor .price").val(),
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_edit_seat/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not create section.");
		}
	});
}

function deleteRow() {
	var row = $(".row-editor").attr("data-row");
	var base = $("body").attr("data-urlbase");

	var data = {
		row: row,
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_delete_row/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not delete.");
		}
	});
}

function deleteSeat() {
	var seat = $(".seat-editor").attr("data-seat");
	var base = $("body").attr("data-urlbase");

	var data = {
		seat: seat,
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_delete_seat/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not delete.");
		}
	});
}

function deleteSection() {
	var section = $(".section-editor").attr("data-section");
	var base = $("body").attr("data-urlbase");

	var data = {
		section: section,
	};

	$.ajax({
		method: "POST",
		url: base + "admin/setup/api_delete_section/",
		data: data,
		success: function(html) {
			//$("body").html(html);
			location.reload();
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not delete.");
		}
	});
}