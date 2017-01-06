function showOrderDetails(id) {
	var response_field = $('#responseField');
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxOrderDetailedInfo.php",
		success: function(response) {
			if(response_field.css('opacity') == 1) {
				response_field.css('opacity', '0');
				setTimeout(function() {
					response_field.html(response + '<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.html(response + '<br /><br />');
				response_field.css('opacity', '1');
			}
		}
	});
}

function selectClient(file_name) {
	$.ajax({
		type: "POST",
		data: {"client": $('#clientSelect').val()},
		url: "../scripts/personal/" + file_name +  ".php",
		success: function(response) {
			var order_response = $('#orderResponse');
			var table = $('#ordersTable');

			if(response == "b") {
				if(order_response.css('opacity') == 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.css('color', '#53acff');
						order_response.html(order_response.html() + "По выбранному критерию заказов не осталось.<br /><br />");
						order_response.css('opacity', 1);
					}, 300);
				} else {
					order_response.css('color', '#53acff');
					order_response.html(order_response.html() + "По выбранному критерию заказов не осталось.<br /><br />");
					order_response.css('opacity', 1);
				}

				if(table.css('opacity') == 1) {
					table.css('opacity', 0);
					setTimeout(function() {
						table.html("");
					}, 300);
				}
			} else {
				var response_field = $('#responseField');

				if(order_response.css('opacity') == 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.html("");
					}, 300);
				}

				if(table.css('opacity') == 1) {
					table.css('opacity', 0);
					setTimeout(function() {
						table.html(response);
						table.css('opacity', 1);
					}, 300);
				} else {
					table.html(response);
					table.css('opacity', 1);
				}

				if(response_field.css('opacity') == 1) {
					response_field.css('opacity', 0);
					setTimeout(function() {
						response_field.html('');
					}, 300);
				}

				var numbers = $('#pageNumbers');
				$.ajax({
					type: "POST",
					data: {"client": $('#clientSelect').val()},
					url: "../scripts/personal/ajaxCalculatePages.php",
					success: function(result) {
						if(numbers.css('opacity') == 1) {
							numbers.css('opacity', 0);
							setTimeout(function() {
								numbers.html(result);
								numbers.css('opacity', 1);
							}, 300);
						} else {
							numbers.html(result);
							numbers.css('opacity', 1);
						}
					}
				});
			}
		}
	});
}

function acceptOrder(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxAcceptOrder.php",
		success: function(response) {
			var order_response = $('#orderResponse');

			if(response == "a") {
				selectClient();
				if(order_response.css('opacity') == 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.css('color', '#53acff');
						order_response.html("Заказ был успешно принят.<br /><br />");
						order_response.css('opacity', 1);
					}, 300);
				} else {
					order_response.css('color', '#53acff');
					order_response.html("Заказ был успешно принят.<br /><br />");
					order_response.css('opacity', 1);
				}
			} else {
				if(order_response.css('opacity') == 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.css('color', '#df4e47');
						order_response.html("Произошла ошибка. Попробуйте снова.<br /><br />");
						order_response.css('opacity', 1);
					}, 300);
				} else {
					order_response.css('color', '#df4e47');
					order_response.html("Произошла ошибка. Попробуйте снова.<br /><br />");
					order_response.css('opacity', 1);
				}
			}
		}
	});
}

function cancelOrder(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxAdminCancelOrder.php",
		success: function(response) {
			var order_response = $('#orderResponse');

			if(response == "a") {
				selectClient();
				if(order_response.css('opacity') == 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.css('color', '#53acff');
						order_response.html("Заказ был успешно отменён.<br /><br />");
						order_response.css('opacity', 1);
					}, 300);
				} else {
					order_response.css('color', '#53acff');
					order_response.html("Заказ был успешно отменён.<br /><br />");
					order_response.css('opacity', 1);
				}
			} else {
				if(order_response.css('opacity') == 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.css('color', '#df4e47');
						order_response.html("Произошла ошибка. Попробуйте снова.<br /><br />");
						order_response.css('opacity', 1);
					}, 300);
				} else {
					order_response.css('color', '#df4e47');
					order_response.html("Произошла ошибка. Попробуйте снова.<br /><br />");
					order_response.css('opacity', 1);
				}
			}
		}
	});
}

function goToPage(page, user) {
	var table = $('#ordersTable');

	$.ajax({
		type: "POST",
		data: {"page": page, "userID": user},
		url: "../scripts/personal/ajaxGoToPage.php",
		success: function(response) {
			table.css('opacity', 0);
			setTimeout(function() {
				table.html(response);
				table.css('opacity', 1);
			}, 300);

			var numbers = $('#pageNumbers');

			$.ajax({
				type: "POST",
				data: {"page": page, "userID": user},
				url: "../scripts/personal/ajaxRebuildPageNumbers.php",
				success: function(result) {
					if(numbers.css('opacity') == 1) {
						numbers.css('opacity', 0);
						setTimeout(function() {
							numbers.html(result);
							numbers.css('opacity', 1);
						}, 300);
					} else {
						numbers.html(result);
						numbers.css('opacity', 1);
					}
				}
			});
		}
	});
}