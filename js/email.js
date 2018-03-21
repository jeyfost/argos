/**
 * Created by jeyfost on 17.07.2017.
 */

function sendEmail(email) {
	var formData = new FormData($('#emailForm').get(0));
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var subject = $('#subjectInput').val();

	formData.append("email", email);
	formData.append("text", text);

	if (subject !== '') {
		if (text !== '' && text !== '<p><br></p>') {
			$.ajax({
				type: "POST",
				data: formData,
				dataType: "json",
				contentType: false,
				processData: false,
				url: "/scripts/personal/ajaxSendEmailToUser.php",
				beforeSend: function () {
					$.notify("Письмо отправляется...", "info");
				},
				success: function (response) {
					switch (response) {
						case "ok":
							$.notify("Письмо было успешно отправлено.", "success");

							$('#subjectInput').val('');
							break;
						case "failed":
							$.notify("Во время отправки письма произошла ошибка. Попробуйте снова.", "error");
							break;
						case "email":
							$.notify("Указанного email-адреса нет среди клиентских адресов.", "error");
							break;
						case "format":
							$.notify("Указанный email-адрес имеет ошибочный формат.", "error");
							break;
						case "files":
							$.notify("Прикрепляемые файлы содержат ошибки. Проверьте их и попробуйте снова.", "error");
							break;
						case "result":
							$.notify("Письмо было отправлено, однако оно не было сохранено в базе данных.", "warn");
							break;
						default:
							$.notify(response, "warn");
							break;
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			});
		} else {
			$.notify("Вы не ввели текст сообщения.", "error");
		}
	} else {
		$.notify("Вы не ввели тему сообщения.", "error");
	}
}