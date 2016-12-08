$(window).on('load', function() {
	if($('div').is('#pbPrev') && $('div').is('#pbNext')) {
		var blockWidth = parseInt($('#pbNext').offset().left + $('#pbNext').width() - $('#pbPrev').offset().left + 40);
		$('#pageNumbers').width(blockWidth);
	}
});

function categoryStyle(action, img, text, imgBlack, imgRed) {
	if(action == 1) {
		document.getElementById(text).style.color = "#df4e47";
		document.getElementById(img).src = "img/icons/" + imgRed;
	} else {
		document.getElementById(text).style.color = "#4f4f4f";
		document.getElementById(img).src = "img/icons/" + imgBlack;
	}
}

function subcategoryStyle(action, id) {
	if(action == 1) {
		document.getElementById(id).style.color = "#df4e47";
	} else {
		document.getElementById(id).style.color = "#4f4f4f";
	}
}

function pageBlock(action, block, text) {
	if(action == 1) {
		document.getElementById(block).style.backgroundColor = "#df4e47";
		document.getElementById(text).style.color = "#fff";
	} else {
		document.getElementById(block).style.backgroundColor = "#fff";
		document.getElementById(text).style.color = "#df4e47";
	}
}

function addToBasket(good_id, input, response_field) {
	var quantity = parseInt(document.getElementById(input).value);

	if(quantity > 0) {
		$.ajax({
			type: 'POST',
			data: {"goodID": good_id, "quantity": quantity},
			url: "scripts/catalogue/ajaxAddToBasket.php",
			success: function(response) {
				switch(response) {
					case "a":
						if(document.getElementById(response_field).style.opacity == 1) {
							document.getElementById(response_field).style.opacity = 0;
							setTimeout(function() {
								document.getElementById(response_field).style.color = "#53acff";
								document.getElementById(response_field).innerHTML = "Товар добавлен в корзину";
								document.getElementById(response_field).style.opacity = "1";
							}, 300);
						} else {
							document.getElementById(response_field).style.color = "#53acff";
							document.getElementById(response_field).innerHTML = "Товар добавлен в корзину";
							document.getElementById(response_field).style.opacity = "1";
						}
						break;
					case "b":
						if(document.getElementById(response_field).style.opacity == 1) {
							document.getElementById(response_field).style.opacity = 0;
							setTimeout(function() {
								document.getElementById(response_field).style.color = "#df4e47";
								document.getElementById(response_field).innerHTML = "Произошла ошибка";
								document.getElementById(response_field).style.opacity = "1";
							}, 300);
						} else {
							document.getElementById(response_field).style.color = "#df4e47";
							document.getElementById(response_field).innerHTML = "Произошла ошибка";
							document.getElementById(response_field).style.opacity = "1";
						}
						break;
					case "c":
						if(document.getElementById(response_field).style.opacity == 1) {
							document.getElementById(response_field).style.opacity = 0;
							setTimeout(function() {
								document.getElementById(response_field).style.color = "#53acff";
								document.getElementById(response_field).innerHTML = "Количество товара в корзине было увеличино на " + quantity;
								document.getElementById(response_field).style.opacity = "1";
							}, 300);
						} else {
							document.getElementById(response_field).style.color = "#53acff";
							document.getElementById(response_field).innerHTML = "Количество товара в корзине было увеличино на " + quantity;
							document.getElementById(response_field).style.opacity = "1";
						}
						break;
					default: break;
				}
			},
		});
	} else {
		if(document.getElementById(response_field).style.opacity == 1) {
			document.getElementById(response_field).style.opacity = 0;
			setTimeout(function() {
				document.getElementById(response_field).style.color = "#df4e47";
				document.getElementById(response_field).innerHTML = "Введите положительное значение";
				document.getElementById(response_field).style.opacity = "1";
			}, 300);
		} else {
			document.getElementById(response_field).style.color = "#df4e47";
			document.getElementById(response_field).innerHTML = "Введите положительное значение";
			document.getElementById(response_field).style.opacity = "1";
		}
	}
}

function hideBlock(id) {
	document.getElementById(id).style.opacity = "0";
	setTimeout(function(){
		document.getElementById(id).innerHTML = "";
	}, 300);
}

function changePrice(good_id, block, price, currency, unit, rate) {
	document.getElementById(block).innerHTML = "<form id='changeGoodPriceForm' method='post'><b>Стоимость за " + unit + " в " + currency + ": </b><input type='number' value='" + price + "' min='0.0001' step='0.0001' id='changeGoodPriceInput' onblur='saveGoodPrice(\"" + good_id + "\", \"" + block + "\", \"" + currency + "\", \"" + unit + "\", \"" + rate + "\")' autofocus /></form><div style='clear: both;'><br /><br /><div id='goodResponseField'></div></div>";
}

function saveGoodPrice(good_id, block, currency, unit, rate) {
	$.ajax({
		type: 'POST',
		data: {"goodID": good_id, "price": $('#changeGoodPriceInput').val()},
		url: "scripts/catalogue/ajaxSaveGoodPrice.php",
		success: function(response) {
			if(response == "a") {
				var price = $('#changeGoodPriceInput').val();
				price = parseFloat(price * rate);
				var roubles = Math.floor(price);
				var kopeck = parseInt(parseFloat(parseFloat(price - roubles).toFixed(2)) * 100);

				if(roubles > 0) {
					price = roubles + " руб. " + kopeck + " коп.";
				} else {
					price = kopeck + " коп.";
				}

				document.getElementById(block).innerHTML = "<span style='cursor: pointer;' onclick='changePrice(\"" + good_id + "\", \"" + block + "\", \"" + $('#changeGoodPriceInput').val() + "\", \"" + currency + "\", \"" + unit + "\", \"" + rate + "\")' title='Изменить стоимость товара'><b>Стоимость за " + unit + ": </b>" + price + "</span>";
			} else {
				if($('#goodResponseFiled').css('opacity') == '0') {
					$('#goodResponseFiled').css('color', '#df4e47');
					$('#goodResponseFiled').val("Введите положительное значение");
				} else {
					$('#goodResponseFiled').css('opacity', '0');
					setTimeout(function() {
						$('#goodResponseFiled').val("Введите положительное значение");
						$('#goodResponseFiled').css('opacity', '1');
					}, 300);
				}
			}
		}
	});
}