
var ticketDialog, customerDialog, performanceDialog, seasonDialog;

$(document).ready(function() {

	ticketDialog = createDialog(".ticket-creator", 520, saveTicket);
	customerDialog = createDialog(".customer-creator", 520, saveCustomer);
	performanceDialog = createDialog(".performance-creator", 520, savePerformance);
	seasonDialog = createDialog(".seasons-creator", 520, saveSeason);
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

function createCustomer() {

}

function saveCustomer() {

}



function showPerformanceDialog() {
	performanceDialog.dialog( "open" );
}

function showPerformanceEditDialog(id) {
	performanceDialog.dialog( "open" );

	json = JSON.parse($("#performance-"+id+" .data").text());
	$(".performance-creator .date").val(json["performance_date"]);
	$(".performance-creator #time").val(json["performance_hour"]);
	$(".performance-creator .open").val(json["performance_open"]);
	$(".performance-creator .canceled").val(json["performance_canceled"]);
}

function savePerformance() {

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
	}

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