$(window).on("load", function() {
	if($('div').is('.catalogueIMG')) {
		$('.catalogueIMG').mouseover(function() {
			$(this).children('.actionIMG').css("opacity", "1");
		});

		$('.catalogueIMG').mouseout(function() {
			$(this).children('.actionIMG').css("opacity", ".6");
		});
	}
});

function actionIcon(id, action) {
	if(action === 1) {
		document.getElementById(id).style.opacity = "1";
	} else {
		document.getElementById(id).style.opacity = ".6";
	}
}

function buttonChange(id, action) {
	if(action === 1) {
		document.getElementById(id).style.color = "#fff";
		document.getElementById(id).style.backgroundColor = "#ff282b";
	} else {
		document.getElementById(id).style.color = "#4c4c4c";
		document.getElementById(id).style.backgroundColor = "#dedede";
	}
}

function fontChange(id, action) {
	if(action === 1) {
		document.getElementById(id).style.color = "#ff282b";
		document.getElementById(id).style.textDecoration = "none";
	} else {
		document.getElementById(id).style.color = "#4c4c4c";
		document.getElementById(id).style.textDecoration = "underline";
	}
}

function pageBlock(action, block, text) {
	if(action === 1) {
		document.getElementById(block).style.backgroundColor = "#ff282b";
		document.getElementById(text).style.color = "#fff";
	} else {
		document.getElementById(block).style.backgroundColor = "#fff";
		document.getElementById(text).style.color = "#ff282b";
	}
}

function textAreaHeight(textarea) {
    if (!textarea._tester) {
        var ta = textarea.cloneNode();
        ta.style.position = 'absolute';
        ta.style.zIndex = 2000000;
        ta.style.visibility = 'hidden';
        ta.style.height = '1px';
        ta.id = '';
        ta.name = '';
        textarea.parentNode.appendChild(ta);
        textarea._tester = ta;
        textarea._offset = ta.clientHeight - 1;
    }
    if (textarea._timer) clearTimeout(textarea._timer);
    textarea._timer = setTimeout(function () {
        textarea._tester.style.width = textarea.clientWidth + 'px';
        textarea._tester.value = textarea.value;
        textarea.style.height = (textarea._tester.scrollHeight - textarea._offset) + 'px';
        textarea._timer = false;
    }, 1);
}

function sendRegistrationEmailAgain(email, hash) {
	$.ajax({
		type: "POST",
		data: {"email": email, "hash": hash},
		url: "/scripts/personal/ajaxSendRegistrationEmail.php",
		beforeSend: function() {
			$.notify("Письмо отправляется...", "info");
		},
		success: function(response) {
			$.notify("Письмо отправлено.", "success");
		},
		error: function(jqXHR, textStatus, errorThrown) {
			$.notify(textStatus + "; " + errorThrown, "error");
		}
	});
}

function scrollToTop() {
    $('html, body').animate({scrollTop: 0}, 500);
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scroll").style.display = "block";
    } else {
        document.getElementById("scroll").style.display = "none";
    }
}

function queryToSession() {
	var query = $('#searchFieldInput').val();
	$('#searchForm').attr("action", "/search/?query=" + query + "&p=1");
}