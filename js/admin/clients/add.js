/**
 * Created by jeyfost on 06.04.2017.
 */

function addClient() {
	var name = $('#nameInput').val();
	var email = $('#emailInput').val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var formData = new FormData($('#addForm').get(0));

	formData.append("text", text);

	if(name !== '') {
		if(email !== '') {
			$.ajax({
				type: "POST",
				data: {"email": email},
				url: "../../scripts/admin/email/ajaxValidateEmail.php",
				success: function (result) {
					if(result === "ok") {
						$.ajax({
							type: "POST",
							data: formData,
							dataType: "json",
							processData: false,
							contentType: false,
							url: "../../scripts/admin/clients/ajaxAddClient.php",
							success: function (response) {
								switch(response) {
									case "ok":
										$.notify("Запись была успешно добавлена в клиентскую базу.", "success");
										break;
									case "failed":
										$.notify("При добавлении записи произошла ошибка.", "error");
										break;
									case "name":
										$.notify("Введённое имя / название организации уже присутствует в клиентской базе.", "error");
										break;
									case "email":
										$.notify("Введённый email-адрес уже присутствует в клиентской базе.", "error");
										break;
									case "phone":
										$.notify("Введённый номер телефона уже присутствует в клиентской базе.", "error");
										break;
									case "district":
										$.notify("Выберите область / город.", "error");
										break;
									case "group":
										$.notify("Выберите группу.", "error");
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
						$.notify("Вы ввели email-адрес недопустимого формата.", "error");
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			})
		} else {
			$.notify("Введите email-адрес.", "error");
		}
	} else {
		$.notify("Введите имя / название организации", "error");
	}
}