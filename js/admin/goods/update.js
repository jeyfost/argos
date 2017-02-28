function makeUpdate() {
	var responseField = $('#responseField');

	if($('#fileSelect').val() != '') {
		var formData = new FormData($('#updateForm').get(0));

		$.ajax({
			type: "POST",
			data: formData,
			dastaType: "json",
			contentType: false,
			processData: false,
			url: "../../scripts/admin/goods/ajaxUpdate.php",
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
				var s = 0;
				var status;

				switch(response) {
					case '"ok"':
						s = 1;
						status = "Данные по товарам были успешно обновлены.";
						break;
					case '"failed"':
						status = "Во время обновления данных произошла ошибка.";
						break;
					case '"partly"':
						status = "Не все товары были обновлены.";
						break;
					default:
						status = response;
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
			error: function(xhr, textStatus) {
				alert([xhr.status, textStatus]);
			}
		});
	} else {
		if(responseField.css('opacity') == 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Выберите файл с выгрузкой.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#df4e47');
			responseField.html("<br />Выберите файл с выгрузкой<br />");
			responseField.css('opacity', 1);
		}
	}
}