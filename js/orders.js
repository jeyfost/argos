function showOrderDetails(id) {
	var response_field = $('#responseField');
	$.ajax({
		type: "POST",
		data: {"id": id},
		url: "/scripts/personal/ajaxOrderDetailedInfo.php",
		success: function(response) {
			if(response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function() {
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
		url: "/scripts/personal/ajaxOrderDetailedInfoHistory.php",
		success: function(response) {
			if(response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function() {
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

function selectClient(file_name) {
	$.ajax({
		type: "POST",
		data: {"client": $('#clientSelect').val()},
		url: "/scripts/personal/" + file_name +  ".php",
		success: function(response) {
			var order_response = $('#orderResponse');
			var table = $('#ordersTable');

			if(response === "b") {
				if(order_response.css('opacity') === 1) {
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

				if(table.css('opacity') === 1) {
					table.css('opacity', 0);
					setTimeout(function() {
						table.html("");
					}, 300);
				}
			} else {
				var response_field = $('#responseField');

				if(order_response.css('opacity') === 1) {
					order_response.css('opacity', 0);
					setTimeout(function() {
						order_response.html("");
					}, 300);
				}

				if(table.css('opacity') === 1) {
					table.css('opacity', 0);
					setTimeout(function() {
						table.html(response);
						table.css('opacity', 1);
					}, 300);
				} else {
					table.html(response);
					table.css('opacity', 1);
				}

				if(response_field.css('opacity') === 1) {
					response_field.css('opacity', 0);
					setTimeout(function() {
						response_field.html('');
					}, 300);
				}

				var numbers = $('#pageNumbers');
				$.ajax({
					type: "POST",
					data: {"client": $('#clientSelect').val()},
					url: "/scripts/personal/ajaxCalculatePages.php",
					success: function(result) {
						if(numbers.css('opacity') === 1) {
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
		url: "/scripts/personal/ajaxAcceptOrder.php",
		success: function(response) {
			var order_response = $('#orderResponse');
			var response_filed = $('#responseField');

			if(response === "a") {
				response_filed.css("opacity", 0);
				setTimeout(function() {
					response_filed.html("");
				}, 300);

				selectClient();
				if(order_response.css('opacity') === 1) {
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

				$.ajax({
					type: 'POST',
					url: "/scripts/personal/ajaxRebuildHistoryTable.php",
					success: function(r) {
						$('#personalContent').html(r);
					}
				});

				$.ajax({
					type: "POST",
					url: "/scripts/personal/ajaxAdminOrdersQuantity.php",
					success: function (quantity) {
						if(quantity > 0) {
							$('#basketLabel').html(quantity);
						} else {
							$('#basketIMG').css('display', 'none');
							$('#basketLabel').css('display', 'none');
							$('#basketLabel').html('');
						}
					}
				});
			} else {
				if(order_response.css('opacity') === 1) {
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
	if(confirm("Вы уверены, что хотите отменить заказ? Удаление будет безвозвратным.")) {
		$.ajax({
			type: "POST",
			data: {"id": id},
			url: "/scripts/personal/ajaxAdminCancelOrder.php",
			success: function(response) {
				var order_response = $('#orderResponse');
				var response_field = $('#responseField');

				if(response === "a") {
					response_field.css("opacity", "0");
					setTimeout(function() {
						response_field.html("");
					}, 300);

					selectClient();
					if(order_response.css('opacity') === 1) {
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

					$.ajax({
						type: 'POST',
						url: "/scripts/personal/ajaxRebuildTableCancel.php",
						success: function(r) {
							$('#personalContent').html(r);
						}
					});

					$.ajax({
						type: "POST",
						url: "/scripts/personal/ajaxAdminOrdersQuantity.php",
						success: function (quantity) {
							if(quantity > 0) {
								$('#basketLabel').html(quantity);
							} else {
								$('#basketIMG').css('display', 'none');
								$('#basketLabel').css('display', 'none');
								$('#basketLabel').html('');
							}
						}
					});
				} else {
					if(order_response.css('opacity') === 1) {
						order_response.css('opacity', 0);
						setTimeout(function() {
							order_response.css('color', '#df4e47');
							order_response.html(response + "<br /><br />");
							order_response.css('opacity', 1);
						}, 300);
					} else {
						order_response.css('color', '#df4e47');
						order_response.html(response + "<br /><br />");
						order_response.css('opacity', 1);
					}
				}
			}
		});
	}
}

function goToPage(page, user) {
	var table = $('#ordersTable');

	$.ajax({
		type: "POST",
		data: {"page": page, "userID": user},
		url: "/scripts/personal/ajaxGoToPage.php",
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
				url: "/scripts/personal/ajaxRebuildPageNumbers.php",
				success: function(result) {
					if(numbers.css('opacity') === 1) {
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

function changeQuantityDetailed(id, order_id) {
	var input = "quantityInput" + id;

	if($('#' + input).val() !== '') {
		$.ajax({
			type: "POST",
			data: {
				"id": id,
				"quantity": $('#' + input).val(),
				"orderID": order_id
			},
			url: "/scripts/personal/ajaxChangeQuantityDetailed.php",
			success: function(response) {
				$('#totalPriceText').html(response);
			}
		});
	}
}

function removeGoodFromOrder(good_id, order_id) {
	$.ajax({
		type: "POST",
		data: {"orderID": order_id},
		url: "/scripts/personal/ajaxCountGoods.php",
		success: function(quantity) {
			if(quantity > 1) {
				var message = "Вы действительно хотите удалить эту группу товаров из заказа?";
			} else {
				var message = "Вы действительно хотите удалить эту группу товаров из заказа? Учтите, что заказ будет отменён, поскольку вы удаляете последний товар в заказе.";
			}

			if(confirm(message)) {
				$.ajax({
					type: "POST",
					data: {
						"goodID": good_id,
						"orderID": order_id
					},
					url: "/scripts/personal/ajaxRemoveGoodFromOrder.php",
					success: function(response) {
						if(response === "a") {
							$.ajax({
								type: "POST",
								data: {"orderID": order_id},
								url: "/scripts/personal/ajaxCalculateOrderPrice.php",
								success: function(result) {
									$('#ci' + good_id).hide('fast');
									$('#cis' + good_id).hide('fast');
									$('#cil' + good_id).hide('fast');
									$('#totalPriceText').html(result);
								}
							});
						}

						if(response === "b") {
							$('#responseField').hide('fast');

							$.ajax({
								type: "POST",
								data: {"orderID": order_id},
								url: "/scripts/personal/ajaxRebuildOrdersTableAdmin.php",
								success: function(r) {
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

function showCommentField(id) {
	var form = "<form method='post' id='orderCommentForm'><div id='temporaryCommentContainer'></div><textarea id='commentInput' onkeydown='textAreaHeight(this)' placeholder='Текст комментария...'></textarea><br /><br /><input type='button' value='Оставить комментарий' id='commentSubmit' onclick='addComment(\"" + id + "\")' onmouseover='buttonChange(\"commentSubmit\", 1)' onmouseout='buttonChange(\"commentSubmit\", 0)' /></form>";
	$('#orderCommentsField').html($('#orderCommentsField').html() + form);
	$('#addComment').html('');

	$('html, body').animate({
		scrollTop: parseInt($('#commentInput').offset().top - 80) + "px"
	}, {
		duration: 200,
		easing: "swing"
	});
}

function addComment(id) {
	var text = $('#commentInput').val();

	if(text !== '' && text !== "Текст комментария...") {
		$.ajax({
			type: "POST",
			data: {
				"order_id": id,
				"text": text
			},
			url: "/scripts/personal/ajaxAddComment.php",
			success: function (response) {
				switch (response) {
					case "ok":
						$.ajax({
							type: "POST",
							data: {"order_id": id},
							url: "/scripts/personal/ajaxLastComment.php",
							success: function (comment) {
								$.ajax({
									type: "POST",
									data: {
										"order_id": id,
										"text": text
									},
									url: "/scripts/personal/ajaxSendEmailWithComment.php",
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