function selectCategory(type, category) {
	window.location = "add.php?type=" + type + "&category=" + category;
}

function selectSubcategory(type, category, subcategory) {
	window.location = "add.php?type=" + type + "&category=" + category + "&subcategory=" + subcategory;
}

function addSection() {
	var responseField = $("#responseField");
	var sectionName = $("#sectionNameInput").val();
	var formData = new FormData($('#addForm').get(0));

	if(sectionName != '') {
		if($('#sectionBlackImg').val() != '') {
			if($('#sectionRedImg').val() != '') {
				$.ajax({
					type: 'POST',
					data: formData,
					dataType: "json",
					contentType: false,
					processData: false,
					url: '../../scripts/admin/sections/ajaxCheckCategory.php',
					success: function(result) {
						if(result == "ok") {
							$.ajax({
								type: 'POST',
								data: formData,
								dataType: "json",
								contentType: false,
								processData: false,
								url: "../../scripts/admin/sections/ajaxAddSection.php",
								beforeSend: function() {
									if(responseField.css('opacity') == 1) {
										responseField.css('opacity', 0);
										setTimeout(function() {
											responseField.html("<br /><img src='../../img/system/spinner.gif' /><br />");
											responseField.css('opacity', 1);
										}, 300);
									} else {
										responseField.css('color', '#df4e47');
										responseField.html("<br /><img src='../../img/system/spinner.gif' /><br />");
										responseField.css('opacity', 1);
									}
								},
								success: function(response) {
									var s;
									var status;

									switch(response) {
										case "ok":
											s = 1;
											status = "Раздел был успешно добавлен.";
											break;
										case "error":
											s = 0;
											status = "При добавлении раздела произошла ошибка.";
											break;
										case "blackImg":
											s = 0;
											status = "Чёрная иконка имеет недопустимый формат.";
											break;
										case "redImg":
											s = 0;
											status = "Красная иконка имеет недопустимый формат.";
											break;
										default:
											status = response;
											break;
									}

									if(responseField.css('opacity') == 1) {
										responseField.css('opacity', 0);
										setTimeout(function() {
											if(s == 1) {
												responseField.css('color', '#53acff');
											} else {
												responseField.css('color', '#df4e47');
											}
											responseField.html("<br />" + status + "<br />");
											responseField.css('opacity', 1);
										}, 300);
									} else {
										if(s == 1) {
											responseField.css('color', '#53acff');
										} else {
											responseField.css('color', '#df4e47');
										}
										responseField.html("<br />" + status + "<br />");
										responseField.css('opacity', 1);
									}
								}
							});
						} else {
							if(responseField.css('opacity') == 1) {
								responseField.css('opacity', 0);
								setTimeout(function() {
									responseField.css('color', '#df4e47');
									responseField.html("<br />Введённое вами название раздела уже существует.<br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								responseField.css('color', '#df4e47');
								responseField.html("<br />Введённое вами название раздела уже существует.<br />");
								responseField.css('opacity', 1);
							}
						}
					}
				});
			} else {
				if(responseField.css('opacity') == 1) {
					responseField.css('opacity', 0);
					setTimeout(function() {
						responseField.css('color', '#df4e47');
						responseField.html("<br />Выберите красную иконку.<br />");
						responseField.css('opacity', 1);
					}, 300);
				} else {
					responseField.css('color', '#df4e47');
					responseField.html("<br />Выберите красную иконку.<br />");
					responseField.css('opacity', 1);
				}
			}
		} else {
			if(responseField.css('opacity') == 1) {
				responseField.css('opacity', 0);
				setTimeout(function() {
					responseField.css('color', '#df4e47');
					responseField.html("<br />Выберите чёрную иконку.<br />");
					responseField.css('opacity', 1);
				}, 300);
			} else {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Выберите чёрную иконку.<br />");
				responseField.css('opacity', 1);
			}
		}
	} else {
		if(responseField.css('opacity') == 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Введите название раздела.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#df4e47');
			responseField.html("<br />Введите название раздела.<br />");
			responseField.css('opacity', 1);
		}
	}
}

function addSubsection() {
	var responseField = $("#responseField");
	var sectionName = $("#sectionNameInput").val();
	var formData = new FormData($('#addForm').get(0));

	if(sectionName != '') {
		$.ajax({
			type: 'POST',
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			url: '../../scripts/admin/sections/ajaxCheckSubcategory.php',
			success: function(result) {
				if(result == "ok") {
					$.ajax({
						type: 'POST',
						data: formData,
						dataType: "json",
						contentType: false,
						processData: false,
						url: "../../scripts/admin/sections/ajaxAddSubsection.php",
						beforeSend: function() {
							if(responseField.css('opacity') == 1) {
								responseField.css('opacity', 0);
								setTimeout(function() {
									responseField.html("<br /><img src='../../img/system/spinner.gif' /><br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								responseField.css('color', '#df4e47');
								responseField.html("<br /><img src='../../img/system/spinner.gif' /><br />");
								responseField.css('opacity', 1);
							}
						},
						success: function(response) {
							var s;
							var status;

							switch(response) {
								case "ok":
									s = 1;
									status = "Подраздел был успешно добавлен.";
									break;
								case "error":
									s = 0;
									status = "При добавлении подраздела произошла ошибка.";
									break;
								default:
									status = response;
									break;
							}

							if(responseField.css('opacity') == 1) {
									responseField.css('opacity', 0);
								setTimeout(function() {
									if(s == 1) {
										responseField.css('color', '#53acff');
									} else {
										responseField.css('color', '#df4e47');
									}
									responseField.html("<br />" + status + "<br />");
									responseField.css('opacity', 1);
								}, 300);
							} else {
								if(s == 1) {
									responseField.css('color', '#53acff');
								} else {
									responseField.css('color', '#df4e47');
								}
								responseField.html("<br />" + status + "<br />");
								responseField.css('opacity', 1);
							}
						}
					});
				} else {
					if(responseField.css('opacity') == 1) {
						responseField.css('opacity', 0);
						setTimeout(function() {
							responseField.css('color', '#df4e47');
							responseField.html("<br />Введённое вами название подраздела уже существует.<br />");
							responseField.css('opacity', 1);
						}, 300);
					} else {
						responseField.css('color', '#df4e47');
						responseField.html("<br />Введённое вами название подраздела уже существует.<br />");
						responseField.css('opacity', 1);
					}
				}
			}
		});
	} else {
		if(responseField.css('opacity') == 1) {
			responseField.css('opacity', 0);
			setTimeout(function() {
				responseField.css('color', '#df4e47');
				responseField.html("<br />Введите название подраздела.<br />");
				responseField.css('opacity', 1);
			}, 300);
		} else {
			responseField.css('color', '#df4e47');
			responseField.html("<br />Введите название подраздела.<br />");
			responseField.css('opacity', 1);
		}
	}
}