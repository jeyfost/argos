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