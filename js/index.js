var baseHeight;

$(window).load(function() {
    baseHeight = $('#mainImg').height();

    $('#mic1').offset({top: 60});
    $('#mic2').offset({top: $('#mic1').height() + $('#mic1').offset().top});
    $('#mic3').offset({top: $('#mic2').height() + $('#mic2').offset().top});
    $('#mic4').offset({top: $('#mic3').height() + $('#mic3').offset().top});

    $('#mainImg').bind('mousewheel', function(event) {
        if(event.originalEvent.wheelDelta > 0) {
            scrollUp();
        } else {
            scrollDown();
        }
    });
});

$(window).resize(function() {
    if($('#mic1').height() < baseHeight) {
        $('#mainImg').height(baseHeight);
    }
});

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
				setTimeout(function() {
					$('#rightSideBlockCategories').html('');
					$('#rightSideBlockCategories').html(response);
					$('#rightSideBlockCategories').css('opacity', '1');
				}, 300);
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
				setTimeout(function() {
					$('#rightSideBlockCategories').html('');
					$('#rightSideBlockCategories').html(response);
					$('#rightSideBlockCategories').css('opacity', '1');
				}, 300);
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
				setTimeout(function () {
					$('#rightSideBlockCategories').html('');
					$('#rightSideBlockCategories').html(response);
					$('#rightSideBlockCategories').css('opacity', '1');
				}, 300);
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
				setTimeout(function() {
					$('#rightSideBlockCategories').html('');
					$('#rightSideBlockCategories').html(response);
					$('#rightSideBlockCategories').css('opacity', '1');
				}, 300);
			}
		});
	}

	if($('#mic3').offset().top < parseInt($('#mainText3').offset().top + 200) && $('#mainText3').offset().top < $('#mic3').offset().top) {
		resetAttributes();
		document.getElementById('mainText3').setAttribute('class', 'mainBigText');

		$.ajax({
			type: 'POST',
			url: 'scripts/index/ajaxLoadCategories.php',
			data: {"type": "ca"},
			beforeSend: function() {
				$('#rightSideBlockCategories').css('opacity', '0');
			},
			success: function(response) {
				setTimeout(function() {
					$('#rightSideBlockCategories').html('');
					$('#rightSideBlockCategories').html(response);
					$('#rightSideBlockCategories').css('opacity', '1');
				}, 300);
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
				setTimeout(function () {
					$('#rightSideBlockCategories').html('');
					$('#rightSideBlockCategories').html(response);
					$('#rightSideBlockCategories').css('opacity', '1');
				}, 300);
			}
		});
	}
}

function resetAttributes() {
    document.getElementById('mainText1').removeAttribute('class');
    document.getElementById('mainText1').setAttribute('class', 'mainSmallText');
    document.getElementById('mainText2').removeAttribute('class');
    document.getElementById('mainText2').setAttribute('class', 'mainSmallText');
    document.getElementById('mainText3').removeAttribute('class');
    document.getElementById('mainText3').setAttribute('class', 'mainSmallText');
    document.getElementById('mainText4').removeAttribute('class');
    document.getElementById('mainText4').setAttribute('class', 'mainSmallText');
}

function scrollFirst() {
    $('#mic1').offset({top: 60});
    $('#mic2').offset({top: $('#mic1').height() + 60});
    $('#mic3').offset({top: $('#mic2').height() + $('#mic2').offset().top});
    $('#mic4').offset({top: $('#mic3').height() + $('#mic3').offset().top});

    resetAttributes();
    document.getElementById('mainText1').removeAttribute('class');
    document.getElementById('mainText1').setAttribute('class', 'mainBigText');

	$.ajax({
		type: 'POST',
		url: 'scripts/index/ajaxLoadCategories.php',
		data: {"type": "fa"},
		beforeSend: function() {
			$('#rightSideBlockCategories').css('opacity', '0');
		},
		success: function(response) {
			setTimeout(function() {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}, 300);
		}
	});
}

function scrollSecond() {
    $('#mic1').css('z-index', '-2');
    $('#mic2').css('z-index', '1');
    $('#mic3').css('z-index', '0');
    $('#mic4').css('z-index', '-1');

    $('#mic1').offset({top: 60 - ($('#mic1').height())});
    heightCheck();
    $('#mic2').offset({top: 60});
    heightCheck();
    $('#mic3').offset({top: $('#mic2').height() + 60});
    heightCheck();
    $('#mic4').offset({top: $('#mic3').height() + $('#mic3').offset().top});
    heightCheck();

    resetAttributes();
    document.getElementById('mainText2').removeAttribute('class');
    document.getElementById('mainText2').setAttribute('class', 'mainBigText');

	$.ajax({
		type: 'POST',
		url: 'scripts/index/ajaxLoadCategories.php',
		data: {"type": "em"},
		beforeSend: function() {
			$('#rightSideBlockCategories').css('opacity', '0');
		},
		success: function(response) {
			setTimeout(function() {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}, 300);
		}
	});
}

function scrollThird() {
    $('#mic1').css('z-index', '0');
    $('#mic2').css('z-index', '-2');
    $('#mic3').css('z-index', '1');
    $('#mic4').css('z-index', '-1');

    $('#mic1').offset({top: $('#mic2').offset().top - $('#mic2').height()});
    heightCheck();
    $('#mic2').offset({top: 60 - $('#mic2').height()});
    heightCheck();
    $('#mic3').offset({top: 60});
    heightCheck();
    $('#mic4').offset({top: 60 + $('#mic3').height()});
    heightCheck();

    resetAttributes();
    document.getElementById('mainText3').removeAttribute('class');
    document.getElementById('mainText3').setAttribute('class', 'mainBigText');

	$.ajax({
		type: 'POST',
		url: 'scripts/index/ajaxLoadCategories.php',
		data: {"type": "ca"},
		beforeSend: function() {
			$('#rightSideBlockCategories').css('opacity', '0');
		},
		success: function(response) {
			setTimeout(function() {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}, 300);
		}
	});
}

function scrollFourth() {
    $('#mic1').css('z-index', '-2');
    $('#mic2').css('z-index', '-1');
    $('#mic3').css('z-index', '0');
    $('#mic4').css('z-index', '1');

    resetOffset();

    $('#mic4').offset({top: 60});
    heightCheck();
    $('#mic3').offset({top: 60 - $('#mic3').height()});
    heightCheck();
    $('#mic2').offset({top: $('#mic3').offset().top - $('#mic2').height()});
    heightCheck();
    $('#mic1').offset({top: $('#mic2').offset().top - $('#mic1').height()});
    heightCheck();

    resetAttributes();
    document.getElementById('mainText4').removeAttribute('class');
    document.getElementById('mainText4').setAttribute('class', 'mainBigText');

	$.ajax({
		type: 'POST',
		url: 'scripts/index/ajaxLoadCategories.php',
		data: {"type": "dg"},
		beforeSend: function() {
			$('#rightSideBlockCategories').css('opacity', '0');
		},
		success: function(response) {
			setTimeout(function() {
				$('#rightSideBlockCategories').html('');
				$('#rightSideBlockCategories').html(response);
				$('#rightSideBlockCategories').css('opacity', '1');
			}, 300);
		}
	});
}

function heightCheck() {
    if($('#mic1').height() < baseHeight) {
        $('#mic1').height(baseHeight);
    }

    if($('#mic2').height() < baseHeight) {
        $('#mic2').height(baseHeight);
    }

    if($('#mic3').height() < baseHeight) {
        $('#mic3').height(baseHeight);
    }

    if($('#mic4').height() < baseHeight) {
        $('#mic4').height(baseHeight);
    }
}

function resetOffset() {
    $('#mic1').offset({top: 60});
    $('#mic2').offset({top: 60});
    $('#mic3').offset({top: 60});
    $('#mic4').offset({top: 60});
}

$('html').keydown(function() {
    if(event.keyCode == 40) {
        scrollDown();
    }
});

$('html').keydown(function() {
    if(event.keyCode == 38) {
        scrollUp();
    }
});