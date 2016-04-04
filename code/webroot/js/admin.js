
var ticketDialog, customerDialog, performanceDialog;

$(document).ready(function() {

	ticketDialog = createDialog(".ticket-creator", 520);
	customerDialog = createDialog(".customer-creator", 520);
	performanceDialog = createDialog(".performance-creator", 380);
	initTicketDialog();
	initCustomerDialog();

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

	json = JSON.parse($("#staff-"+id+" .data").text());
	$(".customer-creator .customer-name").val(json["name"]);
	$(".customer-creator .customer-email").val(json["email"]);
}

function createCustomer() {

}



function showPerformanceDialog() {
	performanceDialog.dialog( "open" );
}
