/**
 * Created by jeyfost on 03.04.2017.
 */

function districtForm() {
	$('#email').hide('300');

	setTimeout(function() {
		$.ajax({
			type: "POST",
			url: "../../scripts/admin/email/ajaxShowDistrictForm.php",
			success: function(html) {
				$('#email').html(html);
				CKEDITOR.replace("text");
				$('#email').show('300');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	}, 300);
}

function setForm() {
	$('#email').hide('300');

	setTimeout(function() {
		$.ajax({
			type: "POST",
			url: "../../scripts/admin/email/ajaxShowSetForm.php",
			success: function(html) {
				$('#email').html(html);
				CKEDITOR.replace("text");
				$('#email').show('300');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	}, 300);
}

function oneForm() {
	$('#email').hide('300');

	setTimeout(function() {
		$('#email').html("<label for='subjectInput'>Тема письма:</label><br /><input type='text' id='subjectInput' name='subject' /><br /><br /><label for='emailInput'>Адрес получателя:</label><br /><input type='text' id='emailInput' name='email' /><br /><br /><label for='textInput'>Текст письма:</label><br /><textarea id='textInput' name='text'></textarea><br /><br /><label for='fileInput'>Добавить вложения:</label><br /><input type='file' class='file' name='attachment[]' multiple='multiple' /><br /><br /><input type='button' class='button' style='margin: 0;' id='sendEmailButton' onmouseover='buttonChange(\"sendEmailButton\", 1)' onmouseout='buttonChange(\"sendEmailButton\", 0)' onclick='sendEmail()' value='Отправить' />");
		CKEDITOR.replace("text");
		$('#email').show('300');
	}, 300);
}

function filterForm() {
	$('#email').hide('300');

	setTimeout(function () {
		$.ajax({
			type: "POST",
			url: "../../scripts/admin/email/ajaxShowFilterForm.php",
			success: function (html) {
				$('#email').html(html);
				CKEDITOR.replace("text");
				$('#email').show('300');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$.notify(textStatus + "; " + errorThrown, "error");
			}
		});
	}, 300);
}

function sendEmail() {
	var formData = new FormData($('#sendForm').get(0));

	$.ajax({
		type: "POST",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		url: "../../scripts/admin/email/ajaxCheckType.php",
		success: function (type) {
			var formData = new FormData($('#sendForm').get(0));
			var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
			var subject = $('#subjectInput').val();

			formData.append("text", text);

			if(subject !== '') {
				if(text !== '' && text !== '<p><br></p>') {
					switch(type) {
						case "set":
							var c = '';

							$('input:checkbox:checked').each(function() {
								c += $(this).val() + ';';
							});

							if(c !== '') {
								formData.append("clients", c);

								$.ajax({
									type: "POST",
									data: formData,
									processData: false,
									contentType: false,
									dataType: "json",
									url: "../../scripts/admin/email/ajaxSendSetEmail.php",
									beforeSend: function () {
										$.notify("Письмо отправляется...", "info");
									},
									success: function (response) {
										switch(response) {
											case "ok":
												$.notify("Письмо успешно отправлено.", "success");
												break;
											case "failed":
												$.notify("При отправке письма произошла ошибка.", "error");
												break;
											case "files":
												$.notify("Некоторые файлы имеют недопустимый формат.", "error");
												break;
											case "result":
												$.notify("Письмо было отправлено, однако результат отправления не был сохранён в базе данных.", "warn");
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
								$.notify("Выберите получателей.", "error");
							}
							break;
						case "one":
							var email = $('#emailInput').val();

							if(email !== '') {
								$.ajax({
									type: "POST",
									data: {"email": email},
									url: "../../scripts/admin/email/ajaxValidateEmail.php",
									success: function (res) {
										if(res === "ok") {
											$.ajax({
												type: "POST",
												data: formData,
												dataType: "json",
												processData: false,
												contentType: false,
												url: "../../scripts/admin/email/ajaxSendOneEmail.php",
												beforeSend: function () {
													$.notify("Письмо отправляется...", "info");
												},
												success: function (response) {
													switch(response) {
														case "ok":
															$.notify("Письмо успешно отправлено.", "success");
															break;
														case "failed":
															$.notify("При отправке письма произошла ошибка.", "error");
															break;
														case "files":
															$.notify("Некоторые файлы имеют недопустимый формат.", "error");
															break;
														case "result":
															$.notify("Письмо было отправлено, однако результат отправления не был сохранён в базе данных.", "warn");
															break;
														default:
															$.notify(response, "warn");
															break;
													}
												}
											});
										} else {
											$.notify("Адрес получаетля имеет неверный формат.", "error");
										}
									},
									error: function(jqXHR, textStatus, errorThrown) {
										$.notify(textStatus + "; " + errorThrown, "error");
									}
								});
							} else {
								$.notify("Введите адрес получателя", "error");
							}
							break;
						default: break;
					}
				}	else {
					$.notify("Введите текст сообщения", "error");
				}
			} else {
				$.notify("Введите тему сообщения", "error");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.notify(textStatus + "; " + errorThrown, "error");
		}
	});
}

function sendDistrictEmail(i) {
	var formData = new FormData($('#sendForm').get(0));
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var subject = $('#subjectInput').val();
	var id = "db" + i;

	formData.append("text", text);
	formData.append("parameter", i);

	if(subject !== '') {
		if(text !== '' && text !== "<p><br></p>") {
			$.ajax({
				type: "POST",
				data: formData,
				dataType: "json",
				processData: false,
				contentType: false,
				url: "../../scripts/admin/email/ajaxSendDistrictEmail.php",
				beforeSend: function () {
					$.notify("Письма отправляются...", "info");
				},
				success: function (response) {
					switch(response) {
						case "ok":
							$.notify("Письма успешно отправлены.", "success");
							break;
						case "failed":
							$.notify("При отправке писем произошла ошибка.", "error");
							break;
						case "files":
							$.notify("Некоторые файлы имеют недопустимый формат.", "error");
							break;
						case "partly":
							$.notify("Не все письма были успешно отправлены.", "warn");
							break;
						default:
							$.notify(response, "warn");
							break;
					}

					$('#' + id).css('color', '#df4e47');
					$('#' + id).css('background-color', '#ddd');
					$('#' + id).css('cursor', 'default');
					$('#' + id).removeAttribute('onclick');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			});
		} else {
			$.notify("Введите текст сообщения", "error");
		}
	} else {
		$.notify("Введите тему сообщения", "error");
	}
}

function sendFilterEmail(i) {
	var formData = new FormData($('#sendForm').get(0));
	var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
	var subject = $('#subjectInput').val();
	var id = "db" + i;

	formData.append("text", text);
	formData.append("parameter", i);

	if(subject !== '') {
		if(text !== '' && text !== "<p><br></p>") {
			$.ajax({
				type: "POST",
				data: formData,
				dataType: "json",
				processData: false,
				contentType: false,
				url: "../../scripts/admin/email/ajaxSendFilterEmail.php",
				beforeSend: function () {
					$.notify("Письма отправляются...", "info");
				},
				success: function (response) {
					switch(response) {
						case "ok":
							$.notify("Письма успешно отправлены.", "success");
							break;
						case "failed":
							$.notify("При отправке писем произошла ошибка.", "error");
							break;
						case "files":
							$.notify("Некоторые файлы имеют недопустимый формат.", "error");
							break;
						case "partly":
							$.notify("Не все письма были успешно отправлены.", "warn");
							break;
						default:
							$.notify(response, "warn");
							break;
					}

					$('#' + id).css('color', '#df4e47');
					$('#' + id).css('background-color', '#ddd');
					$('#' + id).css('cursor', 'default');
					$('#' + id).removeAttribute('onclick');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			});
		} else {
			$.notify("Введите текст сообщения", "error");
		}
	} else {
		$.notify("Введите тему сообщения", "error");
	}
}

function loadDistrictButtons() {
	var formData = new FormData($('#sendForm').get(0));

	$.ajax({
		type: "POST",
		data: formData,
		dataType: "json",
		contentType: false,
		processData: false,
		url: "../../scripts/admin/email/ajaxShowDistrictButtons.php",
		success: function(response) {
			$('#districtButtons').hide('300');

			setTimeout(function () {
				$('#districtButtons').html(response);
				$('#districtButtons').show('300');
			}, 300);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.notify(textStatus + "; " + errorThrown, "error");
		}
	});
}

function loadDistrictButtonsFilter() {
	var district = $('#districtSelect').val();
	var group = $('#groupSelect').val();

	if(district !== "") {
		if(group !== "") {
			$.ajax({
				type: "POST",
				data: {
					"district": district,
					"group": group
				},
				url: "../../scripts/admin/email/ajaxShowDistrictButtonsFilter.php",
				success: function (response) {
					$('#districtButtons').hide('300');

					setTimeout(function () {
						$('#districtButtons').html(response);
						$('#districtButtons').show('300');
					}, 300);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$.notify(textStatus + "; " + errorThrown, "error");
				}
			});
		} else {
			$('#districtButtons').hide('300');
		}
	} else {
		$('#districtButtons').hide('300');
	}
}

function loadClientsGrid() {
	var formData = new FormData($('#sendForm').get(0));

	$.ajax({
		type: "POST",
		data: formData,
		dataType: "json",
		contentType: false,
		processData: false,
		url: "../../scripts/admin/email/ajaxShowClientsGrid.php",
		success: function(response) {
			$('#clientsGrid').hide('300');

			setTimeout(function () {
				$('#clientsGrid').html(response);
				$('#clientsGrid').show('300');
			}, 300);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.notify(textStatus + "; " + errorThrown, "error");
		}
	});
}