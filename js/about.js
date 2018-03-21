$(window).on("load", function() {
	if($('form').is('#CV_Form')) {
		var today = new Date();
		var max = 0;
		var month = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];


		if(today.getMonth() === 1) {
			if(parseInt(today.getFullYear() % 4) === 0) {
				max = 29;
			} else {
				max = 28;
			}
		} else {
			if(today.getMonth() === 0 || today.getMonth() === 2 || today.getMonth() === 4 || today.getMonth() === 6 || today.getMonth() === 7 || today.getMonth() === 9 || today.getMonth() === 11) {
				max = 31;
			} else {
				max = 30;
			}
		}

		for(var i = 1; i <= max; i++) {
			if(i === today.getDate()) {
				$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "' selected>" + i + "</option>");
			} else {
				$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "'>" + i + "</option>");
			}
		}

		for(var i = 0; i <= 11; i++) {
			if(i === today.getMonth()) {
				$('#monthSelect').html($('#monthSelect').html() + "<option value='" + i + "' selected>" + month[i] + "</option>");
			} else {
				$('#monthSelect').html($('#monthSelect').html() + "<option value='" + i + "'>" + month[i] + "</option>");
			}
		}

		for(var i = 1900; i <= today.getFullYear(); i++) {
			if(i === today.getFullYear()) {
				$('#yearSelect').html($('#yearSelect').html() + "<option value='" + i + "' selected>" + i + "</option>");
			} else {
				$('#yearSelect').html($('#yearSelect').html() + "<option value='" + i + "'>" + i + "</option>");
			}
		}
	}
});

function awardBlock(text, photo, action) {
	if(action === 1) {
		document.getElementById(text).style.color = "#df4e47";
		document.getElementById(photo).style.opacity = ".7";
	} else {
		document.getElementById(text).style.color = "#4c4c4c";
		document.getElementById(photo).style.opacity = "1";
	}
}

function galleryPhoto(id, action) {
	if(action === 1) {
		document.getElementById(id).style.opacity = ".7";
	} else {
		document.getElementById(id).style.opacity = "1";
	}
}

function changeDate() {
	var year = $("#yearSelect").val();
	var month = $("#monthSelect").val();
	var max = 0;

	if(month === 1) {
		if(parseInt(year % 4) === 0) {
			max = 29;
		} else {
			max = 28;
		}
	} else {
		if(month === 0 || month === 2 || month === 4 || month === 6 || month === 7 || month === 9 || month === 11) {
			max = 31;
		} else {
			max = 30;
		}
	}

	$('#daySelect').html("");

	for(var i = 1; i <= max; i++) {
		if(i === 1) {
			$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "' selected>" + i + "</option>");
		} else {
			$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "'>" + i + "</option>");
		}
	}
}

function  sendCV() {
	var last_name = $('#inputLastName').val();
	var first_name = $('#inputFirstName').val();
	var patronymic = $('#inputPatronymic').val();
	var city = $('#inputCity').val();
	var phone = $('#inputPhone').val();
	var email = $('#inputEmail').val();
	var text = $('#inputText').val();
	var file = $('#inputCV').val();
	var formData = new FormData($('#CV_Form').get(0));

	if(last_name !== '' && first_name !== '' && patronymic !== '' && city !== '' && phone !== '' && email !== '' && text !== '') {
		if(file !== '') {
			$.ajax({
				type: "POST",
				data: {"email": email},
				url: "/scripts/contacts/ajaxValidateEmail.php",
				success: function (validity) {
					if(validity === "a") {
						$.ajax({
							type: "POST",
							data: formData,
							dataType: "json",
							processData: false,
							contentType: false,
							url: "/scripts/about/ajaxSendCV.php",
							beforeSend: function () {
								$.notify("Ваше резюме отправляется...", "info");
							},
							success: function (response) {
								switch(response) {
									case "ok":
										$.notify("Резюме было успешно отправлено.", "success");

										$('#inputLastName').val('');
										$('#inputFirstName').val('');
										$('#inputPatronymic').val('');
										$('#inputCity').val('');
										$('#inputPhone').val('');
										$('#inputEmail').val('');
										$('#inputText').val('');
										$('#inputCV').val('');
										break;
									case "failed":
										$.notify("Во время отправки произошла ошибка. Попробуйте снова.", "error");
										break;
									case "file":
										$.notify("Файл с резюме отсутствует либо имеет недопустимый формат.", "error");
										break;
									case "captcha":
										$.notify("Вы не прошли проверку на робота. Попробуйте снова", "error");
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
						$.notify("Вы ввели email-адрес недопустимого формата.");
					}
				}
			});
		} else {
			$.notify("Вы не прикрепили своё резюме.", "error");
		}
	} else {
		$.notify("Заполните все поля.", "error")
	}
}