/**
 * Created by jeyfost on 07.04.2017.
 */

function editClient(id) {
	var name = $('#nameInput').val();
	var email = $('#emailInput').val();
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var formData = new FormData($('#editForm').get(0));
	var checkbox;

	if($('#inSendCheckbox').is(':checked')) {
		checkbox = 1;
	} else {
		checkbox = 0;
	}

	formData.append("text", text);
	formData.append("id", id);
	formData.append("checkbox", checkbox);

	if(name !== '') {
		if(email !== '') {
			$.ajax({
				type: "POST",
				data: {"email": email},
				url: "/scripts/admin/email/ajaxValidateEmail.php",
				success: function (result) {
					if(result === "ok") {
						$.ajax({
							type: "POST",
							data: formData,
							dataType: "json",
							processData: false,
							contentType: false,
							url: "/scripts/admin/clients/ajaxEditClient.php",
							success: function (response) {
								switch(response) {
									case "ok":
										$.notify("Запись была успешно изменена.", "success");
										break;
									case "failed":
										$.notify("При редактировании записи произошла ошибка.", "error");
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
			});
		} else {
			$.notify("Введите email-адрес", "error");
		}
	} else {
		$.notify("Введите имя / название организации.", "error");
	}
}
