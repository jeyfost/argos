$(window).on("load", function() {
	$('#nameInput').focus(function() {
		if($('#nameInput').val() === "Ваше имя") {
			$('#nameInput').val("");
			$('#nameInput').css("color", "#4c4c4c");
		}
	});

	$('#nameInput').blur(function() {
		if($('#nameInput').val() === "") {
			$('#nameInput').css("color", "#9e9e9e");
			$('#nameInput').val("Ваше имя");
		}
	});

	$('#emailInput').focus(function() {
		if($('#emailInput').val() === "Ваш email") {
			$('#emailInput').val("");
			$('#emailInput').css("color", "#4c4c4c");
		}
	});

	$('#emailInput').blur(function() {
		if($('#emailInput').val() === "") {
			$('#emailInput').css("color", "#9e9e9e");
			$('#emailInput').val("Ваш email");
		}
	});

	$('#subjectInput').focus(function() {
		if($('#subjectInput').val() === "Тема сообщения") {
			$('#subjectInput').val("");
			$('#subjectInput').css("color", "#4c4c4c");
		}
	});

	$('#subjectInput').blur(function() {
		if($('#subjectInput').val() === "") {
			$('#subjectInput').css("color", "#9e9e9e");
			$('#subjectInput').val("Тема сообщения");
		}
	});

	$('#messageInput').focus(function() {
		if($('#messageInput').val() === "Текст сообщения") {
			$('#messageInput').val("");
			$('#messageInput').css("color", "#4c4c4c");
		}
	});

	$('#messageInput').blur(function() {
		if($('#messageInput').val() === "") {
			$('#messageInput').css("color", "#9e9e9e");
			$('#messageInput').val("Текст сообщения");
		}
	});
});

function sendMail() {
	var name = $('#nameInput').val();
	var email = $('#emailInput').val();
	var subject = $('#subjectInput').val();
	var message = $('#messageInput').val();
	var response_filed = $('#responseField');

	if(name !== "" && name !== "Ваше имя") {
		if(email !== "" && email !== "Ваш email") {
			if(subject !== "" && subject !== "Тема сообщения") {
				if(message !== "" && message !== "Текст сообщения") {
					$.ajax({
						type: "POST",
						data: {"email": email},
						url: "../scripts/contacts/ajaxValidateEmail.php",
						success: function(result) {
							if(result === "a") {
								$.ajax({
									type: "POST",
									data: {"g-recaptcha-response": grecaptcha.getResponse()},
									url: "../scripts/contacts/ajaxValidateCaptcha.php",
									success: function(r) {
										if(r === "a") {
											$.ajax({
												type: "POST",
												data: {
													"name": name,
													"email": email,
													"subject": subject,
													"message": message
												},
												url: "../scripts/contacts/ajaxSendMail.php",
												beforeSend: function() {
													if(response_filed.css("opacity") === "0") {
														response_filed.html("<br /><img src='../img/system/preloader.gif' />");
														response_filed.css("opacity", "1");
													} else {
														response_filed.css("opacity", "0");
														setTimeout(function() {
															response_filed.html("<br /><img src='../img/system/preloader.gif' />");
															response_filed.css("opacity", "1");
														}, 300);
													}
												},
												success: function(response) {
													if(response === "a") {
														if(response_filed.css("opacity") === "0") {
															response_filed.css("color", "#53acff");
															response_filed.html("<br />Письмо успешно отправлено.");
															response_filed.css("opacity", "1");
														} else {
															response_filed.css("opacity", "0");
															setTimeout(function() {
																response_filed.css("color", "#53acff");
																response_filed.html("<br />Письмо успешно отправлено.");
																response_filed.css("opacity", "1");
															}, 300);
														}
													} else {
														if(response_filed.css("opacity") === "0") {
															response_filed.css("color", "#df4e47");
															response_filed.html("<br />При отправке письма прозишла ошибка.");
															response_filed.css("opacity", "1");
														} else {
															response_filed.css("opacity", "0");
															setTimeout(function() {
																response_filed.css("color", "#df4e47");
																response_filed.html("<br />При отправке письма прозиошла ошибка.");
																response_filed.css("opacity", "1");
															}, 300);
														}
													}
												}
											});
										} else {
											if(response_filed.css("opacity") === "0") {
												response_filed.css("color", "#df4e47");
												response_filed.html("<br />Вы не прошли проверку на робота.");
												response_filed.css("opacity", "1");
											} else {
												response_filed.css("opacity", "0");
												setTimeout(function() {
													response_filed.css("color", "#df4e47");
													response_filed.html("<br />Вы не прошли проверку на робота.");
													response_filed.css("opacity", "1");
												}, 300);
											}
										}
									}
								});
							} else {
								if(response_filed.css("opacity") === "0") {
									response_filed.css("color", "#df4e47");
									response_filed.html("<br />Формат введённого вами email-адреса неверен.");
									response_filed.css("opacity", "1");
								} else {
									response_filed.css("opacity", "0");
									setTimeout(function() {
										response_filed.css("color", "#df4e47");
										response_filed.html("<br />Формат введённого вами email-адреса неверен.");
										response_filed.css("opacity", "1");
									}, 300);
								}
							}
						}
					});
				} else {
					if(response_filed.css("opacity") === "0") {
						response_filed.css("color", "#df4e47");
						response_filed.html("<br />Введите текст сообщения.");
						response_filed.css("opacity", "1");
					} else {
						response_filed.css("opacity", "0");
						setTimeout(function() {
							response_filed.css("color", "#df4e47");
							response_filed.html("<br />Введите текст сообщения.");
							response_filed.css("opacity", "1");
						}, 300);
					}
				}
			} else {
				if(response_filed.css("opacity") === "0") {
					response_filed.css("color", "#df4e47");
					response_filed.html("<br />Введите тему сообщения.");
					response_filed.css("opacity", "1");
				} else {
					response_filed.css("opacity", "0");
					setTimeout(function() {
						response_filed.css("color", "#df4e47");
						response_filed.html("<br />Введите тему сообщения.");
						response_filed.css("opacity", "1");
					}, 300);
				}
			}
		} else {
			if(response_filed.css("opacity") === "0") {
				response_filed.css("color", "#df4e47");
				response_filed.html("<br />Введите ваш email-адрес.");
				response_filed.css("opacity", "1");
			} else {
				response_filed.css("opacity", "0");
				setTimeout(function() {
					response_filed.css("color", "#df4e47");
					response_filed.html("<br />Введите ваш email-адрес.");
					response_filed.css("opacity", "1");
				}, 300);
			}
		}
	} else {
		if(response_filed.css("opacity") === "0") {
			response_filed.css("color", "#df4e47");
			response_filed.html("<br />Введите ваше имя.");
			response_filed.css("opacity", "1");
		} else {
			response_filed.css("opacity", "0");
			setTimeout(function() {
				response_filed.css("color", "#df4e47");
				response_filed.html("<br />Введите ваше имя.");
				response_filed.css("opacity", "1");
			}, 300);
		}
	}
}