
$(document).ready(function() {

	$(".payment-method").change(function() {
		if ($(this).val() == "credit") {
			$(".payment-credit").slideDown();
			$(".payment-cash").slideUp();
			$(".process-payment-button").val("Process Payment");
		} else {
			$(".payment-credit").slideUp();
			$(".payment-cash").slideDown();
			$(".process-payment-button").val("Reserve Tickets");
		}
	});

});

function addTicketToCart(seat, performance) {
	var link = $("#addcart-"+seat+"-"+performance);
	var base = $("body").attr("data-urlbase");

	link.text("Adding...");
	link.css({cursor: "default"});
	link.attr("href", "#");

	$.ajax({
		url: base+"cart/api_add/"+seat+"/"+performance,
		success: function(data) {
			var json = JSON.parse(data);
			if (json.status == "409") {
				alert("This ticket is already in your cart.");
				location.reload();
			} else if (json.status == "410") {
				alert("This ticket was purchased by someone else while you were viewing this page.");
				location.reload();
			} else if (json.status == "200") {
				$(".proceed-to-checkout").show();
				link.text("Remove");
				link.attr("href", "javascript:removeTicketFromCart('"+seat+"', '"+performance+"')");
				link.css({cursor: "pointer"});
			}
		},
		error: function(xhr, status, error) {
			$("body").html(xhr.responseText);
			alert("Could not add to cart.");
			location.reload();
		}
	});
}

function removeTicketFromCart(seat, performance) {
	var link = $("#addcart-"+seat+"-"+performance);
	var base = $("body").attr("data-urlbase");

	link.text("Removing...");
	link.css({cursor: "default"});
	link.attr("href", "#");

	$.ajax({
		url: base+"cart/api_remove/"+seat+"/"+performance,
		success: function(data) {
			var json = JSON.parse(data);
			if (json.status == "410") {
				// Ticket wasn't in cart. Something's off. Reload page.
				location.reload();
			} else if (json.status == "200") {
				link.text("Add to Cart");
				link.attr("href", "javascript:addTicketToCart('"+seat+"', '"+performance+"')");
				link.css({cursor: "pointer"});
			}
		},
		error: function() {
			alert("Could not remove from cart.");
			location.reload();
		}
	});
}

function addSeasonTicketToCart(seat, season) {
	var link = $("#addcart-"+seat+"-"+season);
	var base = $("body").attr("data-urlbase");

	link.text("Adding...");
	link.css({cursor: "default"});
	link.attr("href", "#");

	$.ajax({
		url: base+"cart/api_addseason/"+seat+"/"+season,
		success: function(data) {
			var json = JSON.parse(data);
			if (json.status == "409") {
				alert("This ticket is already in your cart.");
				location.reload();
			} else if (json.status == "410") {
				alert("This ticket was purchased by someone else while you were viewing this page.");
				location.reload();
			} else if (json.status == "200") {
				$(".proceed-to-checkout").show();
				link.text("Remove");
				link.attr("href", "javascript:removeSeasonTicketFromCart('"+seat+"', '"+season+"')");
				link.css({cursor: "pointer"});
			}
		},
		error: function() {
			alert("Could not add to cart.");
			location.reload();
		}
	});
}

function removeSeasonTicketFromCart(seat, season) {
	var link = $("#addcart-"+seat+"-"+season);
	var base = $("body").attr("data-urlbase");

	link.text("Removing...");
	link.css({cursor: "default"});
	link.attr("href", "#");

	$.ajax({
		url: base+"cart/api_removeseason/"+seat+"/"+season,
		success: function(data) {
			var json = JSON.parse(data);
			if (json.status == "410") {
				// Ticket wasn't in cart. Something's off. Reload page.
				location.reload();
			} else if (json.status == "200") {
				link.text("Add to Cart");
				link.attr("href", "javascript:addSeasonTicketToCart('"+seat+"', '"+season+"')");
				link.css({cursor: "pointer"});
			}
		},
		error: function() {
			alert("Could not remove from cart.");
			location.reload();
		}
	});
}

function removeTicketFromCartPageById(id) {
	var elem = $("#cart-"+id);
	var link = $("#cart-link-"+id);
	var base = $("body").attr("data-urlbase");

	link.text("Removing...");
	link.css({cursor: "default"});
	link.attr("href", "#");

	$.ajax({
		url: base+"cart/api_remove_item/"+id,
		success: function(data) {
			var json = JSON.parse(data);
			if (json.status == "410") {
				// Ticket wasn't in cart. Something's off. Reload page.
				location.reload();
			} else if (json.status == "200") {
				elem.slideUp(500, function(){
					location.reload();
				});
			}
		},
		error: function() {
			alert("Could not remove from cart.");
			location.reload();
		}
	});
}