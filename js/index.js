$('html').keydown(function () {
	if (event.keyCode === 40) {
		scroll("down");
	}

	if (event.keyCode === 38) {
		scroll("up");
	}
});

var baseHeight;

$(window).load(function () {
	baseHeight = $('#mainImg').height();

	$('#mic1').offset({top: 60});
	$('#mic2').offset({top: $('#mic1').height() + $('#mic1').offset().top});
	$('#mic3').offset({top: $('#mic2').height() + $('#mic2').offset().top});
	$('#mic4').offset({top: $('#mic3').height() + $('#mic3').offset().top});
	$('#mic5').offset({top: $('#mic4').height() + $('#mic4').offset().top});
});

$(window).resize(function () {
	if ($('#mic1').height() < baseHeight) {
		$('#mainImg').height(baseHeight);
	}
});

function resetAttributes() {
	document.getElementById('mainText1').removeAttribute('class');
	document.getElementById('mainText1').setAttribute('class', 'mainSmallText');
	document.getElementById('mainText2').removeAttribute('class');
	document.getElementById('mainText2').setAttribute('class', 'mainSmallText');
	document.getElementById('mainText3').removeAttribute('class');
	document.getElementById('mainText3').setAttribute('class', 'mainSmallText');
	document.getElementById('mainText4').removeAttribute('class');
	document.getElementById('mainText4').setAttribute('class', 'mainSmallText');
	document.getElementById('mainText5').removeAttribute('class');
	document.getElementById('mainText5').setAttribute('class', 'mainSmallText');
}

function scrollFirst() {
	var attribute = $("#mainText1").attr("name");

	if(attribute === "active") {
		window.location.href="/catalogue/index.php?type=fa&p=1";
	} else {
		$("#mainText2").attr("name", "deactive");
		$("#mainText3").attr("name", "deactive");
		$("#mainText4").attr("name", "deactive");
		$("#mainText5").attr("name", "deactive");

		$("#mainText1").attr("name", "active");
	}

	var difference = 60 - $('#mic1').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});
	$('#mic5').offset({top: $('#mic5').offset().top + difference});

	if (document.getElementById('mainText1').getAttribute('class') !== "mainBigText") {
		setTimeout(function () {
			resetAttributes();
			document.getElementById('mainText1').removeAttribute('class');
			document.getElementById('mainText1').setAttribute('class', 'mainBigText');
		}, 300);

		$.ajax({
			type: 'POST',
			url: '/scripts/index/ajaxLoadCategories.php',
			data: {"type": "fa"},
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

function scrollSecond() {
    var attribute = $("#mainText2").attr("name");

    if(attribute === "active") {
        window.location.href="/catalogue/index.php?type=em&p=1";
    } else {
        $("#mainText1").attr("name", "deactive");
        $("#mainText3").attr("name", "deactive");
        $("#mainText4").attr("name", "deactive");
        $("#mainText5").attr("name", "deactive");

        $("#mainText2").attr("name", "active");
    }

	var difference = 60 - $('#mic2').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});
	$('#mic5').offset({top: $('#mic5').offset().top + difference});

	if (document.getElementById('mainText2').getAttribute('class') !== "mainBigText") {
		setTimeout(function () {
			resetAttributes();
			document.getElementById('mainText2').removeAttribute('class');
			document.getElementById('mainText2').setAttribute('class', 'mainBigText');
		}, 300);

		$.ajax({
			type: 'POST',
			url: '/scripts/index/ajaxLoadCategories.php',
			data: {"type": "em"},
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

function scrollThird() {
    var attribute = $("#mainText3").attr("name");

    if(attribute === "active") {
        window.location.href="/catalogue/index.php?type=ca&p=1";
    } else {
        $("#mainText1").attr("name", "deactive");
        $("#mainText2").attr("name", "deactive");
        $("#mainText4").attr("name", "deactive");
        $("#mainText5").attr("name", "deactive");

        $("#mainText3").attr("name", "active");

    }

	var difference = 60 - $('#mic3').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});
	$('#mic5').offset({top: $('#mic5').offset().top + difference});

	if (document.getElementById('mainText3').getAttribute('class') !== "mainBigText") {
		setTimeout(function () {
			resetAttributes();
			document.getElementById('mainText3').removeAttribute('class');
			document.getElementById('mainText3').setAttribute('class', 'mainBigText');
		}, 300);

		$.ajax({
			type: 'POST',
			url: '/scripts/index/ajaxLoadCategories.php',
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

function scrollFourth() {
    var attribute = $("#mainText4").attr("name");

    if(attribute === "active") {
        window.location.href="/catalogue/index.php?type=ht&p=1";
    } else {
        $("#mainText1").attr("name", "deactive");
        $("#mainText2").attr("name", "deactive");
        $("#mainText3").attr("name", "deactive");
        $("#mainText5").attr("name", "deactive");

        $("#mainText4").attr("name", "active");
    }

	var difference = 60 - $('#mic4').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});
	$('#mic5').offset({top: $('#mic5').offset().top + difference});

	if (document.getElementById('mainText4').getAttribute('class') !== "mainBigText") {
		setTimeout(function () {
			resetAttributes();
			document.getElementById('mainText4').removeAttribute('class');
			document.getElementById('mainText4').setAttribute('class', 'mainBigText');
		}, 300);

		$.ajax({
			type: 'POST',
			url: '/scripts/index/ajaxLoadCategories.php',
			data: {"type": "ht"},
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

function scrollFifth() {
    var attribute = $("#mainText5").attr("name");

    if(attribute === "active") {
        window.location.href="/catalogue/index.php?type=dg&p=1";
    } else {
        $("#mainText1").attr("name", "deactive");
        $("#mainText2").attr("name", "deactive");
        $("#mainText3").attr("name", "deactive");
        $("#mainText4").attr("name", "deactive");

        $("#mainText5").attr("name", "active");
    }

	var difference = 60 - $('#mic5').offset().top;

	$('#mic1').offset({top: $('#mic1').offset().top + difference});
	$('#mic2').offset({top: $('#mic2').offset().top + difference});
	$('#mic3').offset({top: $('#mic3').offset().top + difference});
	$('#mic4').offset({top: $('#mic4').offset().top + difference});
	$('#mic5').offset({top: $('#mic5').offset().top + difference});

	if (document.getElementById('mainText5').getAttribute('class') !== "mainBigText") {
		setTimeout(function () {
			resetAttributes();
			document.getElementById('mainText5').removeAttribute('class');
			document.getElementById('mainText5').setAttribute('class', 'mainBigText');
		}, 300);

		$.ajax({
			type: 'POST',
			url: '/scripts/index/ajaxLoadCategories.php',
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

function scroll(direction) {
	if (direction === "up") {
		if (document.getElementById('mainText2').getAttribute('class') === "mainBigText") {
			scrollFirst();
		}

		if (document.getElementById('mainText3').getAttribute('class') === "mainBigText") {
			scrollSecond();
		}

		if (document.getElementById('mainText4').getAttribute('class') === "mainBigText") {
			scrollThird();
		}

		if (document.getElementById('mainText5').getAttribute('class') === "mainBigText") {
			scrollFourth();
		}
	}

	if (direction === "down") {
		if (document.getElementById('mainText1').getAttribute('class') === "mainBigText") {
			scrollSecond();
		}

		if (document.getElementById('mainText2').getAttribute('class') === "mainBigText") {
			scrollThird();
		}

		if (document.getElementById('mainText3').getAttribute('class') === "mainBigText") {
			scrollFourth();
		}

		if (document.getElementById('mainText4').getAttribute('class') === "mainBigText") {
			scrollFifth();
		}
	}
}