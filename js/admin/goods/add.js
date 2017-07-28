function setCode() {
	$.ajax({
		type: "POST",
		url: "../../scripts/admin/goods/ajaxSetCode.php",
		beforeSend: function () {
			$('#preloaderContainer').html("<img src='../../img/system/spinner.gif' />");
			$('#preloaderContainer').css('display', 'block');
		},
		success: function(response) {
			$("#goodCodeInput").val(response);
			$('#preloaderContainer').html("");
		}
	});
}

function checkCode() {
	var code = $('#goodCodeInput').val();

	if(code.length < 4) {
		switch(code.length) {
			case 1:
				code = "000" + code;
				break;
			case 2:
				code = "00" + code;
				break;
			case 3:
				code = "0" + code;
				break;
			default: break;
		}

		$('#goodCodeInput').val(code);
	}
}

function addGood() {
	var responseField = $("#responseField");
	var goodName = $('#goodNameInput').val();
	var goodCode = $('#goodCodeInput').val();
	var goodPrice = $('#goodPriceInput').val();
	var goodDescription = $('#goodDescriptionInput').val();
	var formData = new FormData($('#addForm').get(0));

	if(goodName !== "" && goodCode !== "" && goodPrice !== "" && goodDescription !== "") {
		if($('#goodPhotoInput').val() !== "") {

			$.ajax({
				type: "POST",
				data: formData,
				dataType: "json",
				url: "../../scripts/admin/goods/ajaxAddGood.php",
				contentType: false,
				processData: false,
				beforeSend: function() {
					if(responseField.css('opacity') === 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							responseField.html("<br /><img src='../../img/system/spinner.gif' /><br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						responseField.css('color', '#df4e47');
						responseField.html("<br /><img src='../../img/system/spinner.gif' /><br />");
						responseField.css('opacity', 1);
					}
				},
				success: function(response) {
					var s;
					var status;

					switch(response) {
						case "ok":
							s = 1;
							status = "Товар был успешно добавлен.";
							break;
						case "error":
							s = 0;
							status = "При добавлении товара произошла ошибка.";
							break;
						case "photo":
							s = 0;
							status = "Фотография имеет недопустимый формат.";
							break;
						case "blueprint":
							s = 0;
							status = "Чертёж имеет недопустимый формат.";
							break;
						case "code":
							s = 0;
							status = "Товар с введённым вами артикулом уже существует.";
							break;
						case "price":
							s = 0;
							status = "Стоимость товара не может быть отрицательной.";
							break;
						default:
							status = response;
							break;
					}

					if(responseField.css('opacity') === 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							if(s === 1) {
								responseField.css('color', '#53acff');
							} else {
								responseField.css('color', '#df4e47');
							}
							responseField.html("<br />" + status + "<br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						if(s === 1) {
							responseField.css('color', '#53acff');
						} else {
							responseField.css('color', '#df4e47');
						}
						responseField.html("<br />" + status + "<br />");
						responseField.css('opacity', 1);
					}
				}
			});
		} else {
			if(responseField.css('opacity') === 1) {
				responseField.css('opacity', 0);
				setTimeout(function() {
					responseField.css('color', '#df4e47');
					responseField.html("<br />Прикрепите фотографию товара.<br />");
					responseField.css('opacity', 1);
				}, 300);
			} else {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Прикрепите фотографию товара.<br />");
				responseField.css('opacity', 1);
			}
		}
	} else {
		if(responseField.css('opacity') === 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Заполните все поля.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#df4e47');
			responseField.html("<br />Заполните все поля.<br />");
			responseField.css('opacity', 1);
		}
	}
}

function selectCategory(type, category) {
	window.location = "add.php?type=" + type + "&category=" + category;
}

function selectSubcategory(type, category, subcategory) {
	window.location = "add.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory;
}

function selectSubcategory2(type, category, subcategory, subcategory2) {
	window.location = "add.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2;
}