function removeGood(id) {
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxRemoveGood.php",
		success: function (response) {
			if (response === "a") {
				var block = "ci" + id;
				var space = "cis" + id;
				var line = "cil" + id;

				$('#' + block).hide('fast');
				$('#' + space).hide('fast');
				$('#' + line).hide('fast');

				$.ajax({
					type: "POST",
					url: "../scripts/personal/ajaxBasketQuantity.php",
					success: function (quantity) {
						if (quantity > 0) {
							$('#basketLabel').html(quantity);
							$('#basketQuantityText').html(quantity);
						} else {
							$('#basketLabel').html('');
							$('#basketLabel').hide('fast');
							$('#personalContent').hide('300');
							setTimeout(function () {
								$('#personalContent').html("<span style='font-size: 15px;'><b>На данный момент ваша корзина пуста. Чтобы в ней появились товары, добавьте их <a href='../catalogue/index.php?type=fa&p=1' style='color: #df4e47;'>из каталога</a></b>.</span>");
								$('#personalContent').show('fast');
							}, 300);
						}

						$.ajax({
							type: "POST",
							url: "../scripts/personal/ajaxCalculateTotalPrice.php",
							success: function (result) {
								$('#totalPriceText').html(result);
							}
						});
					}
				});
			}
		}
	});
}

function removeGoodFromOrder(good_id, order_id) {
	$.ajax({
		type: "POST",
		data: {"orderID": order_id},
		url: "../scripts/personal/ajaxCountGoods.php",
		success: function (quantity) {
			if (quantity > 1) {
				var message = "Вы действительно хотите удалить эту группу товаров из вашего заказа?";
			} else {
				var message = "Вы действительно хотите удалить эту группу товаров из вашего заказа? Учтите, что заказ будет отменён, поскольку вы удаляете последний товар в заказе.";
			}

			if (confirm(message)) {
				$.ajax({
					type: "POST",
					data: {"goodID": good_id, "orderID": order_id},
					url: "../scripts/personal/ajaxRemoveGoodFromOrder.php",
					success: function (response) {
						if (response === "a") {
							$.ajax({
								type: "POST",
								data: {"orderID": order_id},
								url: "../scripts/personal/ajaxCalculateOrderPrice.php",
								success: function (result) {
									$('#ci' + good_id).hide('fast');
									$('#cis' + good_id).hide('fast');
									$('#cil' + good_id).hide('fast');
									$('#totalPriceText').html(result);
								}
							});
						}

						if (response === "b") {
							$('#responseField').hide('fast');

							$.ajax({
								type: "POST",
								url: "../scripts/personal/ajaxRebuildOrdersTable.php",
								success: function (r) {
									$('#personalContent').html(r);
								}
							});
						}
					}
				});
			}
		}
	});
}

function clearBasket() {
	var response_field = $('#responseField');

	if (confirm("Вы действительно хотите удалить все товары из корзины?")) {
		$.ajax({
			type: "POST",
			url: "../scripts/personal/ajaxClearBasket.php",
			success: function (response) {
				if (response === "a") {
					$('#personalContent').hide('300');
					$('#basketLabel').html();
					$('#basketLabel').hide('300');
					setTimeout(function () {
						$('#personalContent').html("<span style='font-size: 15px;'><b>На данный момент ваша корзина пуста. Чтобы в ней появились товары, добавьте их <a href='../catalogue/index.php?type=fa&p=1' style='color: #df4e47;'>из каталога</a></b>.</span>");
						$('#personalContent').show('fast');
					}, 300);
				} else {
					if (response_field.css('opacity') === 1) {
						response_field.css('opacity', '0');
						setTimeout(function () {
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
		success: function (response) {
			if (response === "a") {
				$('#personalContent').hide('300');
				$('#basketLabel').html();
				$('#basketLabel').hide('300');
				setTimeout(function () {
					$('#personalContent').html("<span style='font-size: 15px;'><b>Ваш заказ был отправлен менеджерам. Отслеживать статус заказа можно на странице <a href='../personal/basket.php?section=2' style='color: #df4e47;'>\"Активные заявки\"</a></b>.<br /><br />Обращаем ваше внимание, что итоговая стоимость явлеятся приблизительной и может изменяться как в одну, так и в другую сторону в зависимости от изменения курсов валют. Точную сумму в белорусских рублях вам назовут при подтверждении заказа.</span>");
					$('#personalContent').show('fast');
				}, 300);
			} else {
				if (response_field.css('opacity') === 1) {
					response_field.css('opacity', '0');
					setTimeout(function () {
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

	if ($('#' + input).val() !== '') {
		$.ajax({
			type: "POST",
			data: {"id": id, "quantity": $('#' + input).val()},
			url: "../scripts/personal/ajaxChangeQuantity.php",
			success: function (response) {
				$('#totalPriceText').html(response);
			}
		});
	}
}

function changeQuantityDetailed(id, order_id) {
	var input = "quantityInput" + id;

	if ($('#' + input).val() !== '') {
		$.ajax({
			type: "POST",
			data: {"id": id, "quantity": $('#' + input).val(), "orderID": order_id},
			url: "../scripts/personal/ajaxChangeQuantityDetailed.php",
			success: function (response) {
				$('#totalPriceText').html(response);
			}
		});
	}
}

function showOrderDetails(id) {
	var response_field = $('#responseField');
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxOrderInfo.php",
		success: function (response) {
			if (response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function () {
					response_field.html(response + '<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.html(response + '<br /><br />');
				response_field.css('opacity', '1');
			}

			$('html, body').animate({
				scrollTop: parseInt($('#responseField').offset().top - 80) + "px"
			}, {
				duration: 200,
				easing: "swing"
			});
		}
	});
}

function showOrderDetailsHistory(id) {
	var response_field = $('#responseField');
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "../scripts/personal/ajaxOrderInfoHistory.php",
		success: function (response) {
			if (response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function () {
					response_field.html(response + '<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.html(response + '<br /><br />');
				response_field.css('opacity', '1');
			}

			$('html, body').animate({
				scrollTop: parseInt($('#responseField').offset().top - 80) + "px"
			}, {
				duration: 200,
				easing: "swing"
			});
		}
	});
}

function cancelOrder(id) {
	if (confirm("Вы действительно хотите отменить заказ?")) {
		$.ajax({
			type: "POST",
			data: {"id": id},
			url: "../scripts/personal/ajaxCancelOrder.php",
			success: function (response) {
				$('#personalContent').html(response);
			}
		});
	}
}

function showCommentField(id) {
	var form = "<form method='post' id='orderCommentForm'><div id='temporaryCommentContainer'></div><textarea id='commentInput' onkeydown='textAreaHeight(this)' placeholder='Текст комментария...'></textarea><br /><br /><input type='button' value='Оставить комментарий' id='commentSubmit' onclick='addComment(\"" + id + "\")' onmouseover='buttonChange(\"commentSubmit\", 1)' onmouseout='buttonChange(\"commentSubmit\", 0)' /></form>";
	$('#orderCommentsField').html($('#orderCommentsField').html() + form);
	$('#addComment').html('');
}

function addComment(id) {
	var text = $('#commentInput').val();

	if(text !== '' && text !== "Текст комментария...") {
		$.ajax({
			type: "POST",
			data: {"order_id": id, "text": text},
			url: "../scripts/personal/ajaxAddComment.php",
			success: function (response) {
				switch (response) {
					case "ok":
						$.ajax({
							type: "POST",
							data: {"order_id": id},
							url: "../scripts/personal/ajaxLastComment.php",
							success: function (comment) {
								$.ajax({
									type: "POST",
									data: {"order_id": id, "text": text},
									url: "../scripts/personal/ajaxSendEmailWithComment.php",
									success: function() {
										$.notify("Комментарий успешно добавлен.", "success");

										$('#addComment').html('');
										$('#commentInput').val('');
										$('#temporaryCommentContainer').html(comment + "<br />");
									}
								});
							},
							error: function(jqXHR, textStatus, errorThrown) {
								$.notify(textStatus + "; " + errorThrown, "error");
							}
						});
						break;
					case "failed":
						$.notify("Произошла ошибка. Попробуйте снова.", "error");
						break;
					case "id":
						$.notify("Такого заказа не существует.", "error");
						break;
					default:
						$.notify(response, "warn");
						break;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	} else {
		$.notify("Введите текст комментария", "error");
	}
}