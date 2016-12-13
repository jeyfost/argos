function editUserInfo() {
	var company = $('#personalCompanyInput').val();
	var name = $('#personalNameInput').val();
	var position = $('#personalPositionInput').val();
	var phone = $('#personalPhoneInput').val();
	var response_field = $('#goodResponseFiled');

	if(name != '' && phone != '') {
		$.ajax({
			type: "POST",
			data: {"company": company, "name": name, "position": position, "phone": phone},
			url: "../scripts/personal/ajaxEditUserInfo.php",
			success: function(response) {
				switch(response) {
					case "a":
						if(response_field.css('opacity') == 1) {
							response_field.css('opacity', '0');
							setTimeout(function() {
								response_field.css('color', '#53acff');
								response_field.html('Изменения успешно сохранены.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#53acff');
							response_field.html('Изменения успешно сохранены.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "b":
						if(response_field.css('opacity') == 1) {
							response_field.css('opacity', '0');
							setTimeout(function() {
								response_field.css('color', '#df4e47');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#df4e47');
							response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					default: break;
				}
			}
		});
	} else {
		if(response_field.css('opacity') == 1) {
			response_field.css('opacity', '0');
			setTimeout(function() {
				response_field.css('color', '#df4e47');
				response_field.html('Необходимо заполнить поля "Контактное лицо" и "Номер телефона".<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#df4e47');
			response_field.html('Необходимо заполнить поля "Контактное лицо" и "Номер телефона".<br /><br />');
			response_field.css('opacity', '1');
		}
	}
}

function editUserEmail() {
	var email = $('#personalEmailInput').val();
	var response_field = $('#goodResponseFiled');

	if(email != '') {
		$.ajax({
			type: "POST",
			data: {"email": email},
			url: "../scripts/personal/ajaxSendEmailConfirmation.php",
			success: function(response) {
				switch(response) {
					case "a":
						if(response_field.css('opacity') == 1) {
							response_field.css('opacity', '0');
							setTimeout(function() {
								response_field.css('color', '#c');
								response_field.html('Письмо с подтверждением отправлено на указанный адрес <b>' + email + '</b>. Для завершения процедуры смены адреса, перейдите по ссылке, содержащейся в письме.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#53acff');
							response_field.html('Письмо с подтверждением отправлено на указанный адрес <b>' + email + '</b>. Для завершения процедуры смены адреса, перейдите по ссылке, содержащейся в письме.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "b":
						if(response_field.css('opacity') == 1) {
							response_field.css('opacity', '0');
							setTimeout(function() {
								response_field.css('color', '#df4e47');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#df4e47');
							response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "c":
						if(response_field.css('opacity') == 1) {
							response_field.css('opacity', '0');
							setTimeout(function() {
								response_field.css('color', '#df4e47');
								response_field.html('Вы ввели email неверного формата. Уточните адрес.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#df4e47');
							response_field.html('Вы ввели email неверного формата. Уточните адрес.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "d":
						if(response_field.css('opacity') == 1) {
							response_field.css('opacity', '0');
							setTimeout(function() {
								response_field.css('color', '#df4e47');
								response_field.html('Вы ввели email, который уже указан у вас в профиле.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#df4e47');
							response_field.html('Вы ввели email, который уже указан у вас в профиле.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					default: break;
				}
			}
		});
	} else {
		if(response_field.css('opacity') == 1) {
			response_field.css('opacity', '0');
			setTimeout(function() {
				response_field.css('color', '#df4e47');
				response_field.html('Введите новый email.<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#df4e47');
			response_field.html('Введите новый email.<br /><br />');
			response_field.css('opacity', '1');
		}
	}
}

function editUserPassword() {
	var password = $('#personalPasswordInput').val();
	var password_confirm = $('#personalPasswordConfirmInput').val();
	var response_field = $('#goodResponseFiled');

	if(password == '') {
		if(response_field.css('opacity') == 1) {
			response_field.css('opacity', '0');
			setTimeout(function() {
				response_field.css('color', '#df4e47');
				response_field.html('Введите новый пароль.<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#df4e47');
			response_field.html('Введите новый пароль.<br /><br />');
			response_field.css('opacity', '1');
		}
	} else {
		if(password_confirm == '') {
			if(response_field.css('opacity') == 1) {
				response_field.css('opacity', '0');
				setTimeout(function() {
					response_field.css('color', '#df4e47');
					response_field.html('Введите подтверждение нового пароля.<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.css('color', '#df4e47');
				response_field.html('Введите подтверждение нового пароля.<br /><br />');
				response_field.css('opacity', '1');
			}
		} else {
			$.ajax({
				type: "POST",
				data: {"password": password, "passwordConfirm": password_confirm},
				url: "../scripts/personal/ajaxChangePassword.php",
				success: function(response) {
					switch(response) {
						case "a":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#53acff');
									response_field.html('Ваш пароль был успешно изменён.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#53acff');
								response_field.html('Ваш пароль был успешно изменён.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "b":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "c":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Введённые вами пароли не совпадают.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Введённые вами пароли не совпадают.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "d":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Ваш старый пароль совпадает с введённым.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Ваш старый пароль совпадает с введённым.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						default: break;
					}
				}
			});
		}
	}
}