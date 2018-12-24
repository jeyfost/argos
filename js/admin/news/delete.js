/**
 * Created by jeyfost on 22.03.2017.
 */

function selectYear(type, year) {
	window.location = "delete.php?type=" + type + "&year=" + year;
}

function selectNews(type, year, id) {
	window.location = "delete.php?type=" + type + "&year=" + year + "&id=" + id;
}

function deleteNews() {
	if(confirm("Вы действительно хотите удалить эту новость?")) {
		var responseField = $("#responseField");
		var formData = new FormData($('#editForm').get(0));

		$.ajax({
			type: 'POST',
			data: formData,
			dataType: "json",
			processData: false,
			contentType: false,
			url: '/scripts/admin/news/ajaxDeleteNews.php',
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
							status = "Новость была успешно удалена.";
							break;
						case "failed":
							s = 0;
							status = "При удалении новости произошла ошибка.";
							break;
						default:
							s = 0;
							status = response;
							alert(status);
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
	}
}