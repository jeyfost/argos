function removeGood(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxRemoveGood.php",
		success: function(response) {
			if(response == "a") {
				var block = "ci" + id;
				var space = "cis" + id;
				var line = "cil" + id;

				$('#' + block).hide('fast');
				$('#' + space).hide('fast');
				$('#' + line).hide('fast');

				$.ajax({
					type: "POST",
					url: "../scripts/personal/ajaxBasketQuantity.php",
					success: function(quantity) {
						if(quantity > 0) {
							$('#basketLabel').html(quantity);
						} else {
							$('#basketLabel').html('');
							$('#basketLabel').hide('fast');
						}

						$.ajax({
							type: "POST",
							url: "../scripts/personal/ajaxCalculateTotalPrice.php",
							success: function(result) {
								$('#totalPriceText').html(result);
							}
						});
					}
				});
			}
		}
	});
}

function clearBasket() {
	var response_field = $('#responseField');

	if(confirm("Вы действительно хотите удалить все товары из корзины?")) {
		$.ajax({
			type: "POST",
			url: "../scripts/personal/ajaxClearBasket.php",
			success: function(response) {
				if(response == "a") {
					$('#personalContent').hide('300');
					$('#basketLabel').html();
					$('#basketLabel').hide('300');
					setTimeout(function() {
						$('#personalContent').html("<span style='font-size: 15px;'><b>На данный момент ваша корзина пуста. Чтобы в ней появились товары, добавьте их <a href='../catalogue.php?type=fa&p=1' style='color: #df4e47;'>из каталога</a></b>.</span>");
						$('#personalContent').show('fast');
					}, 300);
				} else {
					if(response_field.css('opacity') == 1) {
						response_field.css('opacity', '0');
						setTimeout(function() {
							response_field.css('color', '#53acff');
							response_field.html('Ваш пароль был успешно изменён.<br /><br />');
							response_field.css('opacity', '1');
						}, 300);
					} else {
						response_field.css('color', '#53acff');
						response_field.html('Ваш пароль был успешно изменён.<br /><br />');
						response_field.css('opacity', '1');
					}
				}
			}
		});
	}
}

function sendOrder() {
	var response_field = $('#responseField');

	$.ajax({
		type: "POST",
		url: "../scripts/personal/ajaxSendOrder.php",
		success: function(response) {
			if(response == "a") {
				$('#personalContent').hide('300');
				$('#basketLabel').html();
				$('#basketLabel').hide('300');
				setTimeout(function() {
					$('#personalContent').html("<span style='font-size: 15px;'><b>Ваш заказ был отправлен менеджерам. Отслеживать статус заказа можно на странице <a href='../personal/basket.php?section=2' style='color: #df4e47;'>\"История заказов\"</a></b>.<br /><br />Обращаем ваше внимание, что итоговая стоимость явлеятся приблизительной и может изменяться. Точную сумму вам назовут при подтверждении заказа.</span>");
					$('#personalContent').show('fast');
				}, 300);
			} else {
				if(response_field.css('opacity') == 1) {
					response_field.css('opacity', '0');
					setTimeout(function() {
						response_field.css('color', '#df4e47');
						response_field.html('При оформлении заказа произошла ошибка. Попробуйта снова.<br /><br />');
						response_field.css('opacity', '1');
					}, 300);
				} else {
					response_field.css('color', '#df4e47');
					response_field.html('При оформлении заказа произошла ошибка. Попробуйта снова.<br /><br />');
					response_field.css('opacity', '1');
				}
			}
		}
	});
}

function changeQuantity(id) {
	var input = "quantityInput" + id;

	if($('#' + input).val() != '') {
		$.ajax({
			type: "POST",
			data: {"id": id, "quantity": $('#' + input).val()},
			url: "../scripts/personal/ajaxChangeQuantity.php",
			success: function(response) {
				$('#totalPriceText').html(response);
			}
		});
	}
}