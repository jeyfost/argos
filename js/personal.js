$(window).on('load', function() {
	$('#innerSearchInput').focus(function() {
		if($('#innerSearchInput').val() == "Поиск пользователей...") {
			$('#innerSearchInput').val('');
		} else {
			$.ajax({
				type: 'POST',
				data: {"query": $('#innerSearchInput').val()},
				url: "../scripts/personal/ajaxUserSearch.php",
				success: function(response) {
					$('#innerSearchList').html(response);
					$('#innerSearchList').show('fast');
				}
			});
		}
	});

	$('#innerSearchInput').blur(function() {
		if($('#innerSearchInput').val() == '') {
			$('#innerSearchInput').val("Поиск пользователей...");
		}
	});

	$('#innerSearchInput').keyup(function() {
		if($('#innerSearchInput').val() != '') {
			$.ajax({
				type: 'POST',
				data: {"query": $('#innerSearchInput').val()},
				url: "../scripts/personal/ajaxUserSearch.php",
				success: function(response) {
					$('#innerSearchList').html(response);
					$('#innerSearchList').show('fast');
				}
			});
		} else {
			$('#innerSearchList').hide('fast');
			$('#innerSearchList').html('');
		}
	});
});

function adminEditUser(id) {
	var login = $('#userLoginInput').val();
	var email = $('#userEmailInput').val();
	var password = $('#userPasswordInput').val();
	var company = $('#userCompanyInput').val();
	var name = $('#userNameInput').val();
	var position = $('#userPositionInput').val();
	var phone = $('#userPhoneInput').val();
	var discount = $('#userDiscountInput').val();
	var response_field = $('#responseFiled');

	if(login != '' && email != '' && name != '' && phone != '' && discount != '') {
		if(discount > 0 && discount < 100) {
			$.ajax({
				type: "POST",
				data: {
					"id": id,
					"login": login,
					"email": email,
					"password": password,
					"company": company,
					"name": name,
					"position": position,
					"phone": phone,
					"discount": discount
				},
				url: "../scripts/personal/ajaxAdminEditUser.php",
				success: function(response) {
					switch(response) {
						case "email":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Вы ввели email неверного формата.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Вы ввели email неверного формата.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "emailDuplicate":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Введённый вами email уже существует.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Введённый вами email уже существует.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "emailFailed":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('При изменении email-адреса произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('При изменении email-адреса произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "ok":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#53acff');
									response_field.html('Изменения были успешно сохранены.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#53acff');
								response_field.html('Изменения были успешно сохранены.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "no":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Не было зафиксировано ни одного изменения.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Не было зафиксировано ни одного изменения.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "loginFailed":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('При изменении логина произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('При изменении логина произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "loginDuplicate":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Введённый вами логин уже существует.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Введённый вами логин уже существует.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "passwordFailed":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('При изменении пароля произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('При изменении пароля произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "failed":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('При редактировании основной информации произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('При редактировании основной информации произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						default:
							response_field.css('color', '#df4e47');
							response_field.html(response + '<br /><br />');
							response_field.css('opacity', '1');
							break;
					}
				}
			});
		} else {
			if(response_field.css('opacity') == 1) {
				response_field.css('opacity', '0');
				setTimeout(function() {
					response_field.css('color', '#df4e47');
					response_field.html('Размер скидки должен составлять от 0.01% до 99.99%.<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.css('color', '#df4e47');
				response_field.html('Размер скидки должен составлять от 0.01% до 99.99%.<br /><br />');
				response_field.css('opacity', '1');
			}
		}
	} else {
		if(response_field.css('opacity') == 1) {
			response_field.css('opacity', '0');
			setTimeout(function() {
				response_field.css('color', '#df4e47');
				response_field.html('Необходимо заполнить поля "Логин", "Email", "Контактное лицо", "Номер телефона", "Скидка в %".<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#df4e47');
			response_field.html('Необходимо заполнить поля "Логин", "Email", "Контактное лицо", "Номер телефона", "Скидка в %".<br /><br />');
			response_field.css('opacity', '1');
		}
	}
}

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

function setRates(ids) {
	var response_field = $('#goodResponseFiled');

	$.ajax({
		type: "POST",
		url: "../scripts/personal/ajaxSelectCurrency.php",
		success: function(response) {
			var ids = response.split(',');
			var form = document.forms.currencyForm;
			var values = "";

			for(var i = 0; i < ids.length; i++) {
				values += form.elements[i].value + ';';
			}

			values = values.substr(0, parseInt(values.length - 1));

			$.ajax({
				type: "POST",
				data: {"values": values, "ids": response},
				url: "../scripts/personal/ajaxSetRates.php",
				success: function(result) {
					switch(result) {
						case "a":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#53acff');
									response_field.html('Курсы были успешно установлены.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#53acff');
								response_field.html('Курсы были успешно установлены.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "b":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Произошла ошибка. Не все курсы были установлены.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Произошла ошибка. Не все курсы были установлены.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "c":
							if(response_field.css('opacity') == 1) {
								response_field.css('opacity', '0');
								setTimeout(function() {
									response_field.css('color', '#df4e47');
									response_field.html('Неверный формат ввода.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#df4e47');
								response_field.html('Неверный формат ввода.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "d":
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
		}
	});
}

function sortBy(sort) {
	$.ajax({
		type: "POST",
		data: {"sort": sort},
		url: "../scripts/personal/ajaxSort.php",
		success: function() {
			location.reload();
		}
	});
}

$(document).mouseup(function (e) {
    var container = $("#innerSearchList");
	if(document.getElementById('innerSearchInput') != document.activeElement) {
		if (container.has(e.target).length === 0) {
			container.hide();
		}
	}
});