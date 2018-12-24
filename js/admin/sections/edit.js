function selectCategory(type, category) {
	window.location = "edit.php?type=" + type + "&category=" + category;
}

function selectSubcategory(type, category, subcategory) {
	window.location = "edit.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory;
}

function selectSubcategory2(type, category, subcategory, subcategory2) {
	window.location = "edit.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory + "&subcategory2=" + subcategory2;
}

function editCategory() {
	var responseField = $("#responseField");
	var sectionName = $("#sectionNameInput").val();
	var formData = new FormData($('#editForm').get(0));

	if(sectionName !== '') {
		$.ajax({
			type: 'POST',
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			url: '/scripts/admin/sections/ajaxCheckCategory.php',
			success: function(result) {
				if(result === "ok") {
					$.ajax({
						type: 'POST',
						data: formData,
						dataType: "json",
						contentType: false,
						processData: false,
						url: "/scripts/admin/sections/ajaxEditCategory.php",
						beforeSend: function() {
							if(responseField.css('opacity') === 1) {
								responseField.css('opacity', 0);
								setTimeout(function() {
									responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								responseField.css('color', '#ff282b');
								responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
								responseField.css('opacity', 1);
							}
						},
						success: function(response) {
							var s;
							var status;

							switch(response) {
								case "ok":
									s = 1;
									status = "Раздел был успешно отредактирован.";
									break;
								case "error":
									s = 0;
									status = "При редактировании раздела произошла ошибка.";
									break;
								case "img":
									s = 0;
									status = "При загрузке иконок произошла ошибка.";
									break;
								default:
									status = response;
									break;
							}

							if(responseField.css('opacity') === 1) {
								responseField.css('opacity', 0);
								setTimeout(function() {
									if(s === 1) {
										responseField.css('color', '#53acff');
									} else {
										responseField.css('color', '#ff282b');
									}
									responseField.html("<br />" + status + "<br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								if(s === 1) {
									responseField.css('color', '#53acff');
								} else {
									responseField.css('color', '#ff282b');
								}
								responseField.html("<br />" + status + "<br />");
								responseField.css('opacity', 1);
							}
						}
					});
				} else {
					if(responseField.css('opacity') === 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							responseField.css('color', '#ff282b');
							responseField.html("<br />Введённое вами название раздела уже существует.<br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						responseField.css('color', '#ff282b');
						responseField.html("<br />Введённое вами название раздела уже существует.<br />");
						responseField.css('opacity', 1);
					}
				}
			}
		});
	} else {
		if(responseField.css('opacity') === 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#ff282b');
				responseField.html("<br />Введите название раздела.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#ff282b');
			responseField.html("<br />Введите название раздела.<br />");
			responseField.css('opacity', 1);
		}
	}
}

function editSubcategory() {
	var responseField = $("#responseField");
	var sectionName = $("#sectionNameInput").val();
	var formData = new FormData($('#editForm').get(0));

	if(sectionName !== '') {
		$.ajax({
			type: 'POST',
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			url: '/scripts/admin/sections/ajaxCheckSubcategory.php',
			success: function(result) {
				if(result === "ok") {
					$.ajax({
						type: 'POST',
						data: formData,
						dataType: "json",
						contentType: false,
						processData: false,
						url: "/scripts/admin/sections/ajaxEditSubcategory.php",
						beforeSend: function() {
							if(responseField.css('opacity') === 1) {
								responseField.css('opacity', 0);
								setTimeout(function() {
									responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								responseField.css('color', '#ff282b');
								responseField.html("<br /><img src='/img/system/spinner.gif' /><br />");
								responseField.css('opacity', 1);
							}
						},
						success: function(response) {
							var s;
							var status;

							switch(response) {
								case "ok":
									s = 1;
									status = "Подраздел был успешно отредактирован.";
									break;
								case "error":
									s = 0;
									status = "При редактировании подраздела произошла ошибка.";
									break;
								default:
									status = response;
									break;
							}

							if(responseField.css('opacity') === 1) {
								responseField.css('opacity', 0);
								setTimeout(function() {
									if(s === 1) {
										responseField.css('color', '#53acff');
									} else {
										responseField.css('color', '#ff282b');
									}
									responseField.html("<br />" + status + "<br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								if(s === 1) {
									responseField.css('color', '#53acff');
								} else {
									responseField.css('color', '#ff282b');
								}
								responseField.html("<br />" + status + "<br />");
								responseField.css('opacity', 1);
							}
						}
					});
				} else {
					if(responseField.css('opacity') === 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							responseField.css('color', '#ff282b');
							responseField.html("<br />Введённое вами название подраздела уже существует.<br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						responseField.css('color', '#ff282b');
						responseField.html("<br />Введённое вами название подраздела уже существует.<br />");
						responseField.css('opacity', 1);
					}
				}
			}
		});
	}
}