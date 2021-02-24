function addToBasket(good_id, input, response_field) {
	var quantity = parseFloat(document.getElementById(input).value);

	if(quantity > 0) {
		$.ajax({
			type: 'POST',
			data: {"goodID": good_id, "quantity": quantity},
			url: "/scripts/catalogue/ajaxAddToBasket.php",
			success: function(response) {
				$.ajax({
					type: 'POST',
					data: {"goodID": good_id},
					url: '/scripts/catalogue/ajaxCheckBasket.php',
					success: function(result) {
						if (result === "a") {
							$('#basketIcon').html("<a href='/personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")'><img src='/img/system/basketFull.png' title='Корзина | Товаров в корзине: 1' id='basketIMG' /><div id='basketLabel'>1</div></a>");
						} else {
							$('#basketIcon').html("<a href='/personal/basket.php?section=1' onmouseover='changeIcon(\"basketIMG\", \"basketFullRed.png\")' onmouseout='changeIcon(\"basketIMG\", \"basketFull.png\")'><img src='/img/system/basketFull.png' title='Корзина | Товаров в корзине: " + result + "' id='basketIMG' /><div id='basketLabel'>" + result + "</div></a>");
						}
					}
				});

				switch(response) {
					case "a":
						if(document.getElementById(response_field).style.opacity === 1) {
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
						if(document.getElementById(response_field).style.opacity === 1) {
							document.getElementById(response_field).style.opacity = 0;
							setTimeout(function() {
								document.getElementById(response_field).style.color = "#ff282b";
								document.getElementById(response_field).innerHTML = "Произошла ошибка";
								document.getElementById(response_field).style.opacity = "1";
							}, 300);
						} else {
							document.getElementById(response_field).style.color = "#ff282b";
							document.getElementById(response_field).innerHTML = "Произошла ошибка";
							document.getElementById(response_field).style.opacity = "1";
						}
						break;
					case "c":
						if(document.getElementById(response_field).style.opacity === 1) {
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
			}
		});
	} else {
		if(document.getElementById(response_field).style.opacity === 1) {
			document.getElementById(response_field).style.opacity = 0;
			setTimeout(function() {
				document.getElementById(response_field).style.color = "#ff282b";
				document.getElementById(response_field).innerHTML = "Введите положительное значение";
				document.getElementById(response_field).style.opacity = "1";
			}, 300);
		} else {
			document.getElementById(response_field).style.color = "#ff282b";
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