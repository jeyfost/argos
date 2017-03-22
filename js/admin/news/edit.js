/**
 * Created by jeyfost on 21.03.2017.
 */

function selectYear(type, year) {
	window.location = "edit.php?type=" + type + "&year=" + year;
}

function selectNews(type, year, id) {
	window.location = "edit.php?type=" + type + "&year=" + year + "&id=" + id;
}

function editNews() {
	var responseField = $("#responseField");
	var header = $("#headerInput").val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var formData = new FormData($('#editForm').get(0));

	formData.append("newsText", text);

	if(header != '') {
		if(text != '') {
			$.ajax({
				type: 'POST',
				data: formData,
				dataType: "json",
				processData: false,
				contentType: false,
				url: "../../scripts/admin/news/ajaxEditNews.php",
				beforeSend: function() {
					if(responseField.css('opacity') == 1) {
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
							status = "Новость была успешно отредактирована.";
							break;
						case "failed":
							s = 0;
							status = "При редактировании новости произошла ошибка.";
							break;
						case "preview":
							s = 0;
							status = "При загрузке превью произошла ошибка.";
							break;
						default:
							s = 0;
							status = response;
							alert(status);
							break;
					}

					if(responseField.css('opacity') == 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							if(s == 1) {
								responseField.css('color', '#53acff');
							} else {
								responseField.css('color', '#df4e47');
							}
							responseField.html("<br />" + status + "<br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						if(s == 1) {
							responseField.css('color', '#53acff');
						} else {
							responseField.css('color', '#df4e47');
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
			if(responseField.css('opacity') == 1) {
				responseField.css('opacity', 0);
				setTimeout(function() {
					responseField.css('color', '#df4e47');
					responseField.html("<br />Введите текст новости.<br />");
					responseField.css('opacity', 1);
				}, 300);
			} else {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Введите текст новости.<br />");
				responseField.css('opacity', 1);
			}
		}
	} else {
		if(responseField.css('opacity') == 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Введите заголовок новости.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#df4e47');
			responseField.html("<br />Введите заголовок новости.<br />");
			responseField.css('opacity', 1);
		}
	}
}