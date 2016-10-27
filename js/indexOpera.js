function scrollUp() {
	if($('#mic1').offset().top < 61) {
		if($('#mic1').offset().top > -140) {
			var difference = parseInt(60 - $('#mic1').offset().top);
			$('#mic1').offset({top: $('#mic1').offset().top + difference});
			$('#mic2').offset({top: $('#mic2').offset().top + difference});
			$('#mic3').offset({top: $('#mic3').offset().top + difference});
			$('#mic4').offset({top: $('#mic4').offset().top + difference});

		} else {
			$('#mic4').offset({top: $('#mic4').offset().top + 200});
			$('#mic3').offset({top: $('#mic3').offset().top + 200});
			$('#mic2').offset({top: $('#mic2').offset().top + 200});
			$('#mic1').offset({top: $('#mic1').offset().top + 200});
		}
	}

	if($('#mic2').offset().top > parseInt($('#mainText2').offset().top - 200) && $('#mainText2').offset().top > $('#mic2').offset().top) {
		resetAttributes();
		document.getElementById('mainText1').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "fa"},
			beforeSend: function() {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function(response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}

	if($('#mic3').offset().top > parseInt($('#mainText3').offset().top - 200) && $('#mainText3').offset().top > $('#mic3').offset().top) {
		resetAttributes();
		document.getElementById('mainText2').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "em"},
			beforeSend: function() {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function(response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}

	if($('#mic4').offset().top > parseInt($('#mainText4').offset().top - 200) && $('#mainText4').offset().top > $('#mic4').offset().top) {
		resetAttributes();
		document.getElementById('mainText3').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "ca"},
			beforeSend: function () {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function (response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}
}

function scrollDown() {
	if($('#mic4').offset().top > 61) {
		if ($('#mic4').offset().top < 260) {
			var difference = parseInt($('#mic4').offset().top - 60);

			$('#mic1').offset({top: $('#mic1').offset().top - difference});
			$('#mic2').offset({top: $('#mic2').offset().top - difference});
			$('#mic3').offset({top: $('#mic3').offset().top - difference});
			$('#mic4').offset({top: $('#mic4').offset().top - difference});
		} else {
			$('#mic1').offset({top: $('#mic1').offset().top - 200});
			$('#mic2').offset({top: $('#mic2').offset().top - 200});
			$('#mic3').offset({top: $('#mic3').offset().top - 200});
			$('#mic4').offset({top: $('#mic4').offset().top - 200});
		}
	}

	if($('#mic2').offset().top < parseInt($('#mainText2').offset().top + 200) && $('#mainText2').offset().top < $('#mic2').offset().top) {
		resetAttributes();
		document.getElementById('mainText2').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "em"},
			beforeSend: function() {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function(response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}

	if($('#mic3').offset().top < parseInt($('#mainText3').offset().top + 200) && $('#mainText3').offset().top < $('#mic3').offset().top) {
		setTimeout(function() {
			resetAttributes();
			document.getElementById('mainText3').setAttribute('class', 'mainBigText');
		}, 300);

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "ca"},
			beforeSend: function() {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function(response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}

	if($('#mic4').offset().top < parseInt($('#mainText4').offset().top + 200) && $('#mainText4').offset().top < $('#mic4').offset().top) {
		resetAttributes();
		document.getElementById('mainText4').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "dg"},
			beforeSend: function () {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function (response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}
}

function scrollFirst() {
    var difference = 60 - $('#mic1').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});

	if(document.getElementById('mainText1').getAttribute('class') != "mainBigText") {
		resetAttributes();
		document.getElementById('mainText1').removeAttribute('class');
		document.getElementById('mainText1').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "fa"},
			beforeSend: function () {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function (response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}
}

function scrollSecond() {
    var difference = 60 - $('#mic2').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});

	if(document.getElementById('mainText2').getAttribute('class') != "mainBigText") {
		resetAttributes();
		document.getElementById('mainText2').removeAttribute('class');
		document.getElementById('mainText2').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "em"},
			beforeSend: function () {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function (response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
			}
		});
	}
}

function scrollThird() {
    var difference = 60 - $('#mic3').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});

	if(document.getElementById('mainText3').getAttribute('class') != "mainBigText") {
		resetAttributes();
		document.getElementById('mainText3').removeAttribute('class');
		document.getElementById('mainText3').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "ca"},
			beforeSend: function () {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function (response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}
}

function scrollFourth() {
    var difference = 60 - $('#mic4').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});

	if(document.getElementById('mainText4').getAttribute('class') != "mainBigText") {
		resetAttributes();
		document.getElementById('mainText4').removeAttribute('class');
		document.getElementById('mainText4').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "dg"},
			beforeSend: function () {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function (response) {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}
		});
	}
}