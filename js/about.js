$(window).on("load", function() {
	if($('form').is('#CV_Form')) {
		var today = new Date();
		var max = 0;
		var month = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];


		if(today.getMonth() == 1) {
			if(parseInt(today.getFullYear() % 4) == 0) {
				max = 29;
			} else {
				max = 28;
			}
		} else {
			if(today.getMonth() == 0 || today.getMonth() == 2 || today.getMonth() == 4 || today.getMonth() == 6 || today.getMonth() == 7 || today.getMonth() == 9 || today.getMonth() == 11) {
				max = 31;
			} else {
				max = 30;
			}
		}

		for(var i = 1; i <= max; i++) {
			if(i == today.getDate()) {
				$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "' selected>" + i + "</option>");
			} else {
				$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "'>" + i + "</option>");
			}
		}

		for(var i = 0; i <= 11; i++) {
			if(i == today.getMonth()) {
				$('#monthSelect').html($('#monthSelect').html() + "<option value='" + i + "' selected>" + month[i] + "</option>");
			} else {
				$('#monthSelect').html($('#monthSelect').html() + "<option value='" + i + "'>" + month[i] + "</option>");
			}
		}

		for(var i = 1900; i <= today.getFullYear(); i++) {
			if(i == today.getFullYear()) {
				$('#yearSelect').html($('#yearSelect').html() + "<option value='" + i + "' selected>" + i + "</option>");
			} else {
				$('#yearSelect').html($('#yearSelect').html() + "<option value='" + i + "'>" + i + "</option>");
			}
		}
	}
});

function awardBlock(text, photo, action) {
	if(action == 1) {
		document.getElementById(text).style.color = "#df4e47";
		document.getElementById(photo).style.opacity = ".7";
	} else {
		document.getElementById(text).style.color = "#4c4c4c";
		document.getElementById(photo).style.opacity = "1";
	}
}

function galleryPhoto(id, action) {
	if(action == 1) {
		document.getElementById(id).style.opacity = ".7";
	} else {
		document.getElementById(id).style.opacity = "1";
	}
}

function changeDate() {
	var year = $("#yearSelect").val();
	var month = $("#monthSelect").val();
	var max = 0;

	if(month == 1) {
		if(parseInt(year % 4) == 0) {
			max = 29;
		} else {
			max = 28;
		}
	} else {
		if(month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
			max = 31;
		} else {
			max = 30;
		}
	}

	$('#daySelect').html("");

	for(var i = 1; i <= max; i++) {
		if(i == 1) {
			$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "' selected>" + i + "</option>");
		} else {
			$('#daySelect').html($('#daySelect').html() + "<option value='" + i + "'>" + i + "</option>");
		}
	}
}