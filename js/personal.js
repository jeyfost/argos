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