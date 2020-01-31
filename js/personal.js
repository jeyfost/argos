$(window).on('load', function () {
	$('#innerSearchInput').focus(function () {
		if ($('#innerSearchInput').val() === "Поиск пользователей...") {
			$('#innerSearchInput').val('');
		} else {
			$.ajax({
				type: 'POST',
				data: {"query": $('#innerSearchInput').val()},
				url: "/scripts/personal/ajaxUserSearch.php",
				success: function (response) {
					$('#innerSearchList').html(response);
					$('#innerSearchList').show('fast');
				}
			});
		}
	});

	$('#innerSearchInput').blur(function () {
		if ($('#innerSearchInput').val() === '') {
			$('#innerSearchInput').val("Поиск пользователей...");
		}
	});

	$('#innerSearchInput').keyup(function () {
		if ($('#innerSearchInput').val() !== '') {
			$.ajax({
				type: 'POST',
				data: {"query": $('#innerSearchInput').val()},
				url: "/scripts/personal/ajaxUserSearch.php",
				success: function (response) {
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

	if (login !== '' && email !== '' && name !== '' && phone !== '' && discount !== '') {
		if (discount > 0 && discount < 100) {
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
				url: "/scripts/personal/ajaxAdminEditUser.php",
				success: function (response) {
					switch (response) {
						case "email":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Вы ввели email неверного формата.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Вы ввели email неверного формата.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "emailDuplicate":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Введённый вами email уже существует.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Введённый вами email уже существует.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "emailFailed":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('При изменении email-адреса произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('При изменении email-адреса произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "ok":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
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
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Не было зафиксировано ни одного изменения.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Не было зафиксировано ни одного изменения.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "loginFailed":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('При изменении логина произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('При изменении логина произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "loginDuplicate":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Введённый вами логин уже существует.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Введённый вами логин уже существует.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "passwordFailed":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('При изменении пароля произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('При изменении пароля произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "failed":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('При редактировании основной информации произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('При редактировании основной информации произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						default:
							response_field.css('color', '#ff282b');
							response_field.html(response + '<br /><br />');
							response_field.css('opacity', '1');
							break;
					}
				}
			});
		} else {
			if (response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function () {
					response_field.css('color', '#ff282b');
					response_field.html('Размер скидки должен составлять от 0.01% до 99.99%.<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.css('color', '#ff282b');
				response_field.html('Размер скидки должен составлять от 0.01% до 99.99%.<br /><br />');
				response_field.css('opacity', '1');
			}
		}
	} else {
		if (response_field.css('opacity') === 1) {
			response_field.css('opacity', '0');
			setTimeout(function () {
				response_field.css('color', '#ff282b');
				response_field.html('Необходимо заполнить поля "Логин", "Email", "Контактное лицо", "Номер телефона", "Скидка в %".<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#ff282b');
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
	var response_field = $('#goodResponseField');

	if (name !== '' && phone !== '') {
		$.ajax({
			type: "POST",
			data: {
				"company": company,
				"name": name,
				"position": position,
				"phone": phone
			},
			url: "/scripts/personal/ajaxEditUserInfo.php",
			success: function (response) {
				switch (response) {
					case "a":
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
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
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
								response_field.css('color', '#ff282b');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#ff282b');
							response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					default:
						break;
				}
			}
		});
	} else {
		if (response_field.css('opacity') === 1) {
			response_field.css('opacity', '0');
			setTimeout(function () {
				response_field.css('color', '#ff282b');
				response_field.html('Необходимо заполнить поля "Контактное лицо" и "Номер телефона".<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#ff282b');
			response_field.html('Необходимо заполнить поля "Контактное лицо" и "Номер телефона".<br /><br />');
			response_field.css('opacity', '1');
		}
	}
}

function editUserEmail() {
	var email = $('#personalEmailInput').val();
	var response_field = $('#goodResponseField');

	if (email !== '') {
		$.ajax({
			type: "POST",
			data: {"email": email},
			url: "/scripts/personal/ajaxSendEmailConfirmation.php",
			success: function (response) {
				switch (response) {
					case "a":
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
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
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
								response_field.css('color', '#ff282b');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#ff282b');
							response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "c":
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
								response_field.css('color', '#ff282b');
								response_field.html('Вы ввели email неверного формата. Уточните адрес.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#ff282b');
							response_field.html('Вы ввели email неверного формата. Уточните адрес.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "d":
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
								response_field.css('color', '#ff282b');
								response_field.html('Вы ввели email, который уже указан у вас в профиле.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#ff282b');
							response_field.html('Вы ввели email, который уже указан у вас в профиле.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					case "e":
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
								response_field.css('color', '#ff282b');
								response_field.html('Вы ввели email, который уже используется другим пользователем.<br /><br />');
								response_field.css('opacity', '1');
							}, 300);
						} else {
							response_field.css('color', '#ff282b');
							response_field.html('Вы ввели email, который уже используется другим пользователем.<br /><br />');
							response_field.css('opacity', '1');
						}
						break;
					default:
						break;
				}
			}
		});
	} else {
		if (response_field.css('opacity') === 1) {
			response_field.css('opacity', '0');
			setTimeout(function () {
				response_field.css('color', '#ff282b');
				response_field.html('Введите новый email.<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#ff282b');
			response_field.html('Введите новый email.<br /><br />');
			response_field.css('opacity', '1');
		}
	}
}

function editUserPassword() {
	var password = $('#personalPasswordInput').val();
	var password_confirm = $('#personalPasswordConfirmInput').val();
	var response_field = $('#goodResponseField');

	if (password === '') {
		if (response_field.css('opacity') === 1) {
			response_field.css('opacity', '0');
			setTimeout(function () {
				response_field.css('color', '#ff282b');
				response_field.html('Введите новый пароль.<br /><br />');
				response_field.css('opacity', '1');
			}, 300);
		} else {
			response_field.css('color', '#ff282b');
			response_field.html('Введите новый пароль.<br /><br />');
			response_field.css('opacity', '1');
		}
	} else {
		if (password_confirm === '') {
			if (response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function () {
					response_field.css('color', '#ff282b');
					response_field.html('Введите подтверждение нового пароля.<br /><br />');
					response_field.css('opacity', '1');
				}, 300);
			} else {
				response_field.css('color', '#ff282b');
				response_field.html('Введите подтверждение нового пароля.<br /><br />');
				response_field.css('opacity', '1');
			}
		} else {
			$.ajax({
				type: "POST",
				data: {
					"password": password,
					"passwordConfirm": password_confirm
				},
				url: "/scripts/personal/ajaxChangePassword.php",
				success: function (response) {
					switch (response) {
						case "a":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
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
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "c":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Введённые вами пароли не совпадают.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Введённые вами пароли не совпадают.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "d":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Ваш старый пароль совпадает с введённым.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Ваш старый пароль совпадает с введённым.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						default:
							break;
					}
				}
			});
		}
	}
}

function setRates(ids) {
	var response_field = $('#goodResponseField');

	$.ajax({
		type: "POST",
		url: "/scripts/personal/ajaxSelectCurrency.php",
		success: function (response) {
			var ids = response.split(',');
			var form = document.forms.currencyForm;
			var values = "";

			for (var i = 0; i < ids.length; i++) {
				values += form.elements[i].value + ';';
			}

			values = values.substr(0, parseInt(values.length - 1));

			$.ajax({
				type: "POST",
				data: {
					"values": values,
					"ids": response
				},
				url: "/scripts/personal/ajaxSetRates.php",
				success: function (result) {
					switch (result) {
						case "a":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
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
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Произошла ошибка. Не все курсы были установлены.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Произошла ошибка. Не все курсы были установлены.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "c":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Неверный формат ввода.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Неверный формат ввода.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						case "d":
							if (response_field.css('opacity') === 1) {
								response_field.css('opacity', '0');
								setTimeout(function () {
									response_field.css('color', '#ff282b');
									response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}, 300);
							} else {
								response_field.css('color', '#ff282b');
								response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
								response_field.css('opacity', '1');
							}
							break;
						default:
							break;
					}
				}
			});
		}
	});
}

function setOfficialRates() {
	var response_field = $('#goodResponseField');

	$.ajax({
		type: "POST",
		url: "/scripts/personal/ajaxCheckRates.php",
		beforeSend: function () {
			if (response_field.css('opacity') === 1) {
				response_field.css('opacity', '0');
				setTimeout(function () {
					response_field.html("<img src='/img/system/spinner.gif' /><br /><br />");
					response_field.css("opacity", "1");
				}, 300);
			} else {
				response_field.html("<img src='/img/system/spinner.gif' /><br /><br />");
				response_field.css("opacity", "1");
			}
		},
		success: function (result) {
			if (result === "not actual") {
				$.ajax({
					type: "POST",
					url: "/scripts/personal/ajaxSetOfficialRates.php",
					beforeSend: function () {
						if (response_field.css('opacity') === 1) {
							response_field.css('opacity', '0');
							setTimeout(function () {
								response_field.html("<img src='/img/system/spinner.gif' /><br /><br />");
								response_field.css("opacity", "1");
							}, 300);
						} else {
							response_field.html("<img src='/img/system/spinner.gif' /><br /><br />");
							response_field.css("opacity", "1");
						}
					},
					success: function (response) {
						switch (response) {
							case "ok":
								$.ajax({
									type: "POST",
									data: {"code": "USD"},
									url: "/scripts/personal/ajaxGetRate.php",
									success: function (rate) {
										$('#currencyInput1').val(rate);
									}
								});

								$.ajax({
									type: "POST",
									data: {"code": "RUB"},
									url: "/scripts/personal/ajaxGetRate.php",
									success: function (rate) {
										$('#currencyInput2').val(rate);
									}
								});

								$.ajax({
									type: "POST",
									data: {"code": "EUR"},
									url: "/scripts/personal/ajaxGetRate.php",
									success: function (rate) {
										$('#currencyInput3').val(rate);
									}
								});

								if (response_field.css('opacity') === 1) {
									response_field.css('opacity', '0');
									setTimeout(function () {
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
							case "partly":
								if (response_field.css('opacity') === 1) {
									response_field.css('opacity', '0');
									setTimeout(function () {
										response_field.css('color', '#ff282b');
										response_field.html('Не все курсы были успешно обновлены.<br /><br />');
										response_field.css('opacity', '1');
									}, 300);
								} else {
									response_field.css('color', '#ff282b');
									response_field.html('Не все курсы были успешно обновлены.<br /><br />');
									response_field.css('opacity', '1');
								}
								break;
							case "failed":
								if (response_field.css('opacity') === 1) {
									response_field.css('opacity', '0');
									setTimeout(function () {
										response_field.css('color', '#ff282b');
										response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
										response_field.css('opacity', '1');
									}, 300);
								} else {
									response_field.css('color', '#ff282b');
									response_field.html('Произошла ошибка. Попробуйте снова.<br /><br />');
									response_field.css('opacity', '1');
								}
								break;
							default:
								break;
						}
					}
				});
			} else {
				if (response_field.css('opacity') === 1) {
					response_field.css('opacity', '0');
					setTimeout(function () {
						response_field.css('color', '#53acff');
						response_field.html('Обновление не требуется. Актуальные курсы уже установлены.<br /><br />');
						response_field.css('opacity', '1');
					}, 300);
				} else {
					response_field.css('color', '#53acff');
					response_field.html('Обновление не требуется. Актуальные курсы уже установлены.<br /><br />');
					response_field.css('opacity', '1');
				}
			}
		}
	});
}

function sortBy(sort) {
	$.ajax({
		type: "POST",
		data: {"sort": sort},
		url: "/scripts/personal/ajaxSort.php",
		success: function () {
			location.reload();
		}
	});
}

function unsubscribe(hash) {
	if(confirm("Вы уверены, что хотите отписаться от рассылки и потерять персональную скидку?")) {
		$.ajax({
			type: "POST",
			data: {"hash": hash},
			url: "/scripts/personal/ajaxUnsubscribe.php",
			success: function (response) {
                switch (response) {
                    case "ok":
                        $.notify("Вы были отписаны от рассылки. Заявка на аннулирование скидки отправлена менеджерам.", "success");

                        setTimeout(function () {
                            window.location.href = "/";
                        }, 3000);
                        break;
                    case "hash":
                        $.notify("Личный идентификатор пользователя указан с ошибкой. Попробуйте снова или обратитесь к нашим менеджерам.", "warn");
                        break;
                    case "failed":
                        $.notify("Произошла ошибка. Попробуйте снова или обратитесь к нашим менеджерам.", "error");
                        break;
                    default:
                        break;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
		});
	}
}

$(document).mouseup(function (e) {
	var container = $("#innerSearchList");
	if (document.getElementById('innerSearchInput') !== document.activeElement) {
		if (container.has(e.target).length === 0) {
			container.hide();
		}
	}
});