function addNews() {
	var responseField = $("#responseField");
	var header = $("#headerInput").val();
	var preview = $("#previewInput").val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var formData = new FormData($('#addForm').get(0));

	formData.append("newsText", text);

	if(header !== '') {
		if(preview !== '') {
			if(text !== '' && text !== '<p><br></p>') {
				$.ajax({
					type: 'POST',
					data: formData,
					dataType: "json",
					processData: false,
					contentType: false,
					url: '/scripts/admin/news/ajaxAddNews.php',
					beforeSend: function() {
						if(responseField.css('opacity') === 1) {
							responseField.css('opacity', 0);
							setTimeout(function() {
								responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
								responseField.css('opacity', 1);
							}, 300);
						} else {
							responseField.css('color', '#ff282b');
							responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
							responseField.css('opacity', 1);
						}
					},
					success: function(response) {
						var s;
						var status;

						switch(response) {
							case "ok":
								s = 1;
								status = "Новость была успешно добалвена.";
								break;
							case "failed":
								s = 0;
								status = "При добавлении новости произошла ошибка.";
								break;
							case "preview":
								s = 0;
								status = "При загрузке превью произошла ошибка.";
								break;
							default:
								s = 0;
								status = response;
								break;
						}

						if(responseField.css('opacity') === 1) {
							responseField.css('opacity', 0);
							setTimeout(function() {
								if(s === 1) {
									responseField.css('color', '#53acff');
								} else {
									responseField.css('color', '#ff282b');
								}
								responseField.html("<br />" + status + "<br />");
								responseField.css('opacity', 1);
							}, 300);
						} else {
							if(s === 1) {
								responseField.css('color', '#53acff');
							} else {
								responseField.css('color', '#ff282b');
							}
							responseField.html("<br />" + status + "<br />");
							responseField.css('opacity', 1);
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
					  alert(textStatus + "; " + errorThrown);
					}
				});
			} else {
				if(responseField.css('opacity') === 1) {
					responseField.css('opacity', 0);
					setTimeout(function() {
						responseField.css('color', '#ff282b');
						responseField.html("<br />Введите текст новости.<br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					responseField.css('color', '#ff282b');
					responseField.html("<br />Введите текст новости.<br />");
					responseField.css('opacity', 1);
				}
			}
		} else {
			if(responseField.css('opacity') === 1) {
				responseField.css('opacity', 0);
				setTimeout(function() {
					responseField.css('color', '#ff282b');
					responseField.html("<br />Выберите превью новости.<br />");
					responseField.css('opacity', 1);
				}, 300);
			} else {
				responseField.css('color', '#ff282b');
				responseField.html("<br />Выберите превью новости.<br />");
				responseField.css('opacity', 1);
			}
		}
	} else {
		if(responseField.css('opacity') === 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#ff282b');
				responseField.html("<br />Введите заголовок новости.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#ff282b');
			responseField.html("<br />Введите заголовок новости.<br />");
			responseField.css('opacity', 1);
		}
	}
}