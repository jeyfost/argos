/**
 * Created by jeyfost on 27.03.2017.
 */

function editAction() {
	var header = $("#headerInput").val();
	var from_date = $('#fromInput').val();
	var to_date = $('#toInput').val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var goods = document.getElementsByClassName('goodBlock');
	var inputs = document.getElementsByClassName('actionGoodPrice');
	var goodsID = [];
	var goodsPrice = [];
	var formData = new FormData($('#editForm').get(0));

	if(goods.length > 0) {
		for(var i = 0; i < goods.length; i++) {
			if(goods[i].innerHTML !== '') {
				goodsID[i] = goods[i].getAttribute("good_id");
				goodsPrice[i] = inputs[i].value;
			}
		}

		formData.append("goodsID", goodsID);
		formData.append("goodsPrice", goodsPrice);
	}

	formData.append("actionText", text);

	if(header !== '') {
		if(from_date !== '') {
			if(to_date !== '') {
				if(text !== '' && text !== "<p><br></p>") {
					$.ajax({
						type: "POST",
						data: formData,
						dataType: "json",
						processData: false,
						contentType: false,
						url: "/scripts/admin/actions/ajaxEditAction.php",
						success: function (response) {
							switch(response) {
								case "ok":
									$.notify("Акция была успешно отредактирована.", "success");
									break;
								case "failed":
									$.notify("Во время редактирования акции произошла ошибка.", "error");
									break;
								case "from":
									$.notify("Неверно указан формат даты начала акции.", "error");
									break;
								case "to":
									$.notify("Неверно указан формат даты окончания акции.", "error");
									break;
								case "goods":
									$.notify("Акция была отредактирована, но с добавлением товаров произошла ошибка. Один или несколько товаров уже участвуют в акциях, подпадающих под указанный временной диапазон.", "error");
									break;
								case "prices":
									$.notify("Введите акционные цены всех товаров.", "error");
									break;
								case "time":
									$.notify("Дата окончания акции не может быть раньше даты начала.", "error");
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
					$.notify("Введите описание акции", "error");
				}
			} else {
				$.notify("Введите дату окончания акции", "error");
			}
		} else {
			$.notify("Введите дату начала акции", "error");
		}
	} else {
		$.notify("Введите название акции", "error");
	}
}