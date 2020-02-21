$(window).on("load", function() {
    $('#orderSearchInput').on("keyup", function () {
        if($('#orderSearchInput').val() !== '') {
            searchOrder();
        } else {
            if($('#orderSearchInput').css('display') !== "none") {
                $('#orderSearchListAdmin').hide("fast");
            }
        }
    });

    $('#orderSearchInput').on("focus", function () {
        if($('#orderSearchInput').val() !== '') {
            searchOrder();
        } else {
            if($('#orderSearchInput').css('display') !== "none") {
                $('#orderSearchListAdmin').hide("fast");
            }
        }
    });

    $('#orderHistorySearchInput').on("keyup", function () {
        if($('#orderHistorySearchInput').val() !== '') {
            searchHistoryOrder();
        } else {
            if($('#orderHistorySearchInput').css('display') !== "none") {
                $('#orderHistorySearchListAdmin').hide("fast");
            }
        }
    });

    $('#orderHistorySearchInput').on("focus", function () {
        if($('#orderHistorySearchInput').val() !== '') {
            searchHistoryOrder();
        } else {
            if($('#orderHistorySearchInput').css('display') !== "none") {
                $('#orderHistorySearchListAdmin').hide("fast");
            }
        }
    });
});

$(document).mouseup(function (e) {
    var sl = $("#orderSearchListAdmin");
    if(document.getElementById('orderSearchInput') !== document.activeElement) {
        if (sl.has(e.target).length === 0){
            sl.hide('fast');
        }
    }

    var s2 = $("#orderHistorySearchListAdmin");
    if(document.getElementById('orderHistorySearchInput') !== document.activeElement) {
        if (s2.has(e.target).length === 0){
            s2.hide('fast');
        }
    }
});

function searchOrder() {
    var query = $('#orderSearchInput').val();

    if(query !== 'Номер заказа...' && query !== '') {
        $.ajax({
            type: "POST",
            data: {"query": query},
            url: "/scripts/personal/ajaxSearchActiveOrderAdmin.php",
            success: function (response) {
                $('#orderSearchListAdmin').html(response);
                $('#orderSearchListAdmin').show('fast');
            }
        });
    }
}

function searchHistoryOrder() {
    var query = $('#orderHistorySearchInput').val();

    if(query !== 'Номер заказа...' && query !== '') {
        $.ajax({
            type: "POST",
            data: {"query": query},
            url: "/scripts/personal/ajaxSearchHistoryOrderAdmin.php",
            success: function (response) {
                $('#orderHistorySearchListAdmin').html(response);
                $('#orderHistorySearchListAdmin').show('fast');
            }
        });
    }
}

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
	var employee = $('#employeeSelect').val();

	if(employee !== '') {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "employee": employee
            },
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
                            order_response.css('color', '#ff282b');
                            order_response.html("Произошла ошибка. Попробуйте снова.<br /><br />");
                            order_response.css('opacity', 1);
                        }, 300);
                    } else {
                        order_response.css('color', '#ff282b');
                        order_response.html("Произошла ошибка. Попробуйте снова.<br /><br />");
                        order_response.css('opacity', 1);
                    }
                }
            }
        });
	} else {
		$.notify("Выберите сотрудника, принимающего заказ.", "error");
	}
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
							order_response.css('color', '#ff282b');
							order_response.html(response + "<br /><br />");
							order_response.css('opacity', 1);
						}, 300);
					} else {
						order_response.css('color', '#ff282b');
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

	if($('#' + input).val() !== '' && parseInt($('#' + input).val()) > 0) {
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

function removeGoodFromOrder(good_id, order_id, user_id) {
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
								data: {
									"order_id": order_id,
									"user_id": user_id
								},
								url: "/scripts/personal/ajaxRecalculateOrderPriceAfterDelete.php",
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

function addGoodToOrder(user_id, order_id) {
    var base_html = $('#goodsBlock').html();
    var random_id = md5(Math.random(0, 1000000) + md5(Date.now()));

    var new_html = "<div class='orderGoodBlock' id='" + random_id + "' style='background-color: #f8f8f8;'><div style='float: right;'><img src='/img/system/delete.png' style='cursor: pointer;' id='di" + random_id + "' onmouseover='changeDeleteIcon(\"di" + random_id + "\", 1)' onmouseout='changeDeleteIcon(\"di" + random_id + "\", 0)' title='Убрать этот блок' onclick='closeGoodBlock(\"" + random_id +"\", \"" + user_id + "\", \"" + order_id + "\")' /></div><div style='clear: both;'></div><br /><input type='text' id='search_" + random_id + "' class='searchFieldInput' value='Поиск...' onfocus='searchFocus(\"search_" + random_id + "\", \"" + user_id + "\", \"" + order_id + "\")' onblur='searchBlur(\"search_" + random_id + "\")' onkeyup='searchGood(\"search_" + random_id +"\", \"" + user_id + "\", \"" + order_id + "\")' /><br /><div id='g_" + random_id + "' class='goodBlock'></div><div style='clear: both;'></div></div></div>";

    $('#goodsBlock').html(base_html + new_html);
}

function closeGoodBlock(block, user_id, order_id, good_id) {
	$('#' + block).hide('300');
    closeSearchList();

    $.ajax({
        type: "POST",
        data: {
			"order_id": order_id,
			"good_id": good_id
		},
		url: "/scripts/personal/ajaxCloseGoodBlock.php",
		success: function (response) {
        	switch(response) {
				case "ok":
                    setTimeout(function() {
                        $('#' + block).remove();
                    }, 300);

                    recalculateOrderPriceAfterDelete(user_id, order_id);
					break;
				case "failed":
                    $.notify("Добавленный товар не был удалён. Необходимо перезагрузить страницу и удалить снова.", "error");
					break;
				default:
					break;
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.notify(textStatus + "; " + errorThrown, "error");
        }
    });
}

function changeDeleteIcon(id, action) {
    if(action === 1) {
        document.getElementById(id).src = "/img/system/deleteRed.png";
    } else {
        document.getElementById(id).src = "/img/system/delete.png";
    }
}

function searchFocus(id, user_id, order_id) {
    var search = document.getElementById(id).value;

    if(search === "Поиск...") {
        document.getElementById(id).value = '';
    }

}

function searchBlur(id) {
    var search = document.getElementById(id).value;

    if(search === '') {
        document.getElementById(id).value = 'Поиск...';
    }

}

function searchGood(id, user_id, order_id) {
    var search = $('#' + id).val();
    var searchList = $('#orderGoodsSearchList');

    if(search !== "Поиск..." || search !== "") {
        var x = $('#' + id).offset().left;
        var y = parseInt($('#' + id).offset().top + 40);

        searchList.offset({top: y, left: x});
        searchList.show('300');
	}

    if(search !== '') {
        $.ajax({
            type: 'POST',
            data: {
                "search": search,
                "id": id,
				"user_id": user_id,
				"order_id": order_id
            },
            url: "/scripts/personal/ajaxOrderSearch.php",
            success: function(response) {
                searchList.html('');
                searchList.html("<div style='float: right;'><img src='/img/system/delete.png' style='cursor: pointer;' id='sl_" + id + "' onmouseover='changeDeleteIcon(\"sl_" + id + "\", 1)' onmouseout='changeDeleteIcon(\"sl_" + id + "\", 0)' title='Закрыть результат поиска' onclick='closeSearchList()' /></div><div style='clear: both;'></div>" + response);

                var x = $('#' + id).offset().left;
                var y = parseInt($('#' + id).offset().top + 40);

                searchList.offset({top: y, left: x});
                searchList.show('300');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
        });
    } else {
        searchList.hide('300');

        setTimeout(function() {
            searchList.html('');
        }, 300)
    }
}

function closeSearchList() {
    $('#orderGoodsSearchList').hide('300');
}

function chooseGood(id, block, user_id, order_id) {
    var random_id = block.substr(2);

    $.ajax({
        type: 'POST',
        data: {
        	"id": id,
			"block": block,
			"user_id": user_id,
			"order_id": order_id
		},
        url: "/scripts/personal/ajaxChooseGood.php",
        success: function(response) {
        	if(response === "duplicate") {
				$.notify("Этот товар уже есть в заявке.", "error");
			} else {
                $('#' + block).html(response);
                $('#' + block).attr("good_id", id);
                $('#search_' + block.substring(2)).val("Поиск...");
                closeSearchList();

                recalculateOrderPrice(user_id, order_id, id);

                $('#di' + random_id).attr("onclick", "closeGoodBlock('" + random_id + "', '" + user_id + "', '" + order_id + "', '" + id + "')");
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.notify(textStatus + "; " + errorThrown, "error");
        }
    });
}

function recalculateOrderPrice(user_id, order_id, good_id) {
	$.ajax({
		type: "POST",
		data: {
			"user_id": user_id,
			"order_id": order_id,
			"good_id": good_id
		},
		url: "/scripts/personal/ajaxRecalculateOrderPrice.php",
		success: function (response) {
			$('#totalPriceText').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.notify(textStatus + "; " + errorThrown, "error");
        }
	});
}

function recalculatePriceFromInput(good_id, user_id, order_id, block) {
	var quantity = $('#' + block).val();

	if(quantity !== "" && parseInt(quantity) > 0) {
        $.ajax({
			type: "POST",
			data: {
				"good_id": good_id,
				"user_id": user_id,
				"order_id": order_id,
				"quantity": quantity
			},
			url: "/scripts/personal/ajaxRecalculateOrderPriceFromInput.php",
			success: function (response) {
                $('#totalPriceText').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
        });
	}
}

function recalculateOrderPriceAfterDelete(user_id, order_id) {
	$.ajax({
		type: "POST",
		data: {
			"user_id": user_id,
			"order_id": order_id
		},
		url: "/scripts/personal/ajaxRecalculateOrderPriceAfterDelete.php",
		success: function (response) {
            $('#totalPriceText').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $.notify(textStatus + "; " + errorThrown, "error");
        }
	});
}

function checkQuantity(block, order_id, user_id, good_id) {
	var quantity = $('#' + block).val();

	if(quantity === '' || parseInt(quantity) <= 0) {
		$('#' + block).val("1");
		recalculatePriceFromInput(good_id, user_id, order_id, block);
	}
}