
var ticketDialog, customerDialog, performanceDialog;

$(document).ready(function() {

	ticketDialog = createDialog(".ticket-creator", 520);
	customerDialog = createDialog(".customer-creator", 520);
	performanceDialog = createDialog(".performance-creator", 520);
	initTicketDialog();
	initCustomerDialog();
	initTheaterSwitcher();

	$( ".datepicker" ).datepicker();

});

function createDialog(selector, height) {
	dialog = $(selector).dialog({
		autoOpen: false,
		height: height,
		width: 600,
		modal: true,
		buttons: {
			"Save Changes": function() {

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



function initTheaterSwitcher() {
	$(".admin-theater-switcher").change(function() {
		urlbase = $("body").attr("data-urlbase");
		window.location = urlbase + "admin/settings/select/" + $(this).val() + "/";
	});
}