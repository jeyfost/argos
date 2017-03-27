/**
 * Created by jeyfost on 22.03.2017.
 */

function changeDeleteIcon(id, action) {
	if(action == 1) {
		document.getElementById(id).src = "../../img/system/deleteRed.png";
	} else {
		document.getElementById(id).src = "../../img/system/delete.png";
	}
}

function searchFocus(id) {
	var search = document.getElementById(id).value;
	var searchList = $('#searchList');

	if(search == "Поиск...") {
		document.getElementById(id).value = '';
	}
}

function closeSearchList() {
	$('#searchList').hide('300');
}

function closeGoodBlock(id) {
	$('#' + id).hide('300');
	closeSearchList();

	setTimeout(function() {
		$('#' + id).remove();
	}, 300);
}

function searchGood(id) {
	var search = $('#' + id).val();
	var searchList = $('#searchList');

	if(search != '') {
		$.ajax({
			type: 'POST',
			data: {"search": search, "id": id},
			url: "../../scripts/admin/actions/ajaxSearch.php",
			success: function(response) {
				searchList.html('');
				searchList.html("<div style='float: right;'><img src='../../img/system/delete.png' style='cursor: pointer;' id='sl_" + id + "' onmouseover='changeDeleteIcon(\"sl_" + id + "\", 1)' onmouseout='changeDeleteIcon(\"sl_" + id + "\", 0)' title='Закрыть результат поиска' onclick='closeSearchList()' /></div><div style='clear: both;'></div>" + response);

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

function chooseGood(id, block) {
	$.ajax({
		type: 'POST',
		data: {"id": id, "block": block},
		url: "../../scripts/admin/actions/ajaxChooseGood.php",
		success: function(response) {
			$('#' + block).html(response);
			$('#' + block).attr("good_id", id);
			$('#search_' + block.substring(2)).val("Поиск...");
			closeSearchList();
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.notify(textStatus + "; " + errorThrown, "error");
		}
	});
}

function addGoodBlock() {
	var base_html = $('#goodsBlock').html();
	var random_id = md5(Math.random(0, 1000000) + md5(Date.now()));
	var new_html = "<div class='actionGoodBlock' id='" + random_id + "' style='background-color: #f8f8f8;'><div style='float: right;'><img src='../../img/system/delete.png' style='cursor: pointer;' id='di" + random_id + "' onmouseover='changeDeleteIcon(\"di" + random_id + "\", 1)' onmouseout='changeDeleteIcon(\"di" + random_id + "\", 0)' title='Убрать этот блок' onclick='closeGoodBlock(\"" + random_id +"\")' /></div><div style='clear: both;'><br /><label for='search_" + random_id + "'></label><br /><input type='text' id='search_" + random_id + "' class='searchFieldInput' value='Поиск...' onfocus='searchFocus(\"search_" + random_id + "\")' onblur='searchBlur(\"search_" + random_id + "\")' onkeyup='searchGood(\"search_" + random_id +"\")' /><br /><div id='g_" + random_id + "' class='goodBlock'></div><div style='clear: both;'></div></div></div>";

	$('#goodsBlock').html(base_html + new_html);
}

function addAction() {
	var header = $("#headerInput").val();
	var preview = $("#previewInput").val();
	var from_date = $('#fromInput').val();
	var to_date = $('#toInput').val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var goods = document.getElementsByClassName('goodBlock');
	var inputs = document.getElementsByClassName('actionGoodPrice');
	var goodsID = [];
	var goodsPrice = [];
	var formData = new FormData($('#addForm').get(0));

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

	formData.append("newsText", text);

	if(header !== '') {
		if(preview !== '') {
			if(from_date !== '') {
				if(to_date !== '') {
					if(text !== '' && text !== "<p><br></p>") {
						$.ajax({
							type: "POST",
							data: formData,
							dataType: "json",
							processData: false,
							contentType: false,
							url: "../../scripts/admin/actions/ajaxAddAction.php",
							success: function (response) {
								switch(response) {
									case "ok":
										$.notify("Акция была успешно добавлена.", "success");
										break;
									case "failed":
										$.notify("Во время добавления акции произошла ошибка.", "error");
										break;
									case "from":
										$.notify("Неверно указан формат даты начала акции.", "error");
										break;
									case "to":
										$.notify("Неверно указан формат даты окончания акции.", "error");
										break;
									case "goods":
										$.notify("Акция была добавлена, но с добавлением товаров произошла ошибка. Один или несколько товаров уже участвуют в акциях, подпадающих под указанный временной диапазон.", "error");
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
			$.notify("Выберите превью акции", "error");
		}
	} else {
		$.notify("Введите название акции", "error");
	}
}