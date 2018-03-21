/**
 * Created by jeyfost on 18.07.2017.
 */

function adminActiveOrder(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "/scripts/personal/ajaxOrderDetailedInfo.php",
		success: function (response) {
			$('#orderBlock').html(response);
		}
	});
}

function adminInactiveOrder(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "/scripts/personal/ajaxOrderDetailedInfoHistory.php",
		success: function (response) {
			$('#orderBlock').html(response);
		}
	});
}

function userActiveOrder(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "/scripts/personal/ajaxOrderInfo.php",
		success: function (response) {
			$('#orderBlock').html(response);
		}
	});
}

function userInactiveOrder(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "/scripts/personal/ajaxOrderInfoHistory.php",
		success: function (response) {
			$('#orderBlock').html(response);
		}
	});
}