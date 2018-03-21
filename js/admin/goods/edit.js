function selectCategory(type, category) {
	window.location = "edit.php?type=" + type + "&category=" + category;
}

function selectSubcategory(type, category, subcategory) {
	window.location = "edit.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory;
}

function selectSubcategory2(type, category, subcategory, subcategory2) {
	window.location = "edit.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2;
}

function selectGood(type, category, subcategory, subcategory2, id) {
	window.location = "edit.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2 + "&id=" + id;
}

function setCode() {
	$.ajax({
		type: "POST",
		url: "/scripts/admin/goods/ajaxSetCode.php",
		beforeSend: function () {
			$('#preloaderContainer').html("<img src='/img/system/spinner.gif' />");
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

function editGood() {
	var responseField = $("#responseField");
	var goodName = $('#goodNameInput').val();
	var goodCode = $('#goodCodeInput').val();
	var goodCurrency = $('#currencySelect').val();
	var goodPrice = $('#goodPriceInput').val();
	var goodUnit = $('#unitSelect').val();
	var goodDescription = $('#goodDescriptionInput').val();
	var formData = new FormData($('#editForm').get(0));

	if(goodName !== '' && goodCode !== '' && goodCurrency !== '' && goodUnit !== '' && goodDescription !== '') {
		if(parseInt(goodPrice) > 0) {
			$.ajax({
				type: "POST",
				data: formData,
				dataType: "json",
				url: "/scripts/admin/goods/ajaxEditGood.php",
				contentType: false,
				processData: false,
				beforeSend: function() {
					if(responseField.css('opacity') === 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						responseField.css('color', '#df4e47');
						responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
						responseField.css('opacity', 1);
					}
				},
				success: function(response) {
					var s = 0;
					var status;

					switch(response) {
						case "ok":
							s = 1;
							status = "Товар успешно отрадактирован.";
							break;
						case "failed":
							status = "При редактировании товара произошла ошибка.";
							break;
						case "photo":
							status = "При загрузке фотографии произошла ошибка.";
							break;
						case "blueprint":
							status = "При загрузке чертежа произошла ошибка.";
							break;
						case "additionalPhotos":
							status = "При загрузке дополнительных фотографий произошла ошибка.";
							break;
						case "code":
							status = "Товар с указанным артикулом уже существует.";
							break;
						case "photos":
							status = "При загрузке фотографии и чертежа произошла ошибка.";
							break;
						default:
							status = response;
							break;
					}

					$.ajax({
						type: "POST",
						data: formData,
						dataType: "json",
						processData: false,
						contentType: false,
						url: "/scripts/admin/goods/ajaxRebuildPhotosContainer.php",
						success: function (code) {
							$('#goodPhotosContainer').css("opacity", 0);

							setTimeout(function () {
								$('#goodPhotosContainer').html(code);
							}, 300);

							$('#goodPhotosContainer').css("opacity", 1);
						},
						error: function(xhr, textStatus) {
							$.notify(textStatus + "; " + errorThrown, "error");
						}
					});

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
				},
				error: function(xhr, textStatus) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			});
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

function deletePhoto(photo_id) {
	if(confirm("Вы действительно хотите удаить эту фотографию?")) {
		$.ajax({
			type: "POST",
			data: {"photo_id": photo_id},
			url: "/scripts/admin/goods/ajaxDeletePhoto.php",
			success: function (response) {
				switch (response) {
					case "ok":
						$.notify("Фотография была успешно удалена.", "success");
						break;
					case "failed":
						$.notify("При удалении фотографии произошла ошибка.", "error");
						break;
					default:
						$.notify(response, "warn");
						break;
				}

				var formData = new FormData($('#editForm').get(0));

				$.ajax({
					type: "POST",
					data: formData,
					dataType: "json",
					processData: false,
					contentType: false,
					url: "/scripts/admin/goods/ajaxRebuildPhotosContainer.php",
					success: function (code) {
						$('#goodPhotosContainer').css("opacity", 0);

						setTimeout(function () {
							$('#goodPhotosContainer').html(code);
							$('#goodPhotosContainer').css("opacity", 1);
						}, 300)
					},
					error: function(xhr, textStatus) {
						$.notify(textStatus + "; " + errorThrown, "error");
					}
				});
			},
			error: function(xhr, textStatus) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	}
}

function fadePhoto(id, action) {
	if(action === 1) {
		document.getElementById(id).style.opacity = ".7";
	} else {
		document.getElementById(id).style.opacity = "1";
	}
}