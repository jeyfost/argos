function showDropdownList(action, id, highlighted) {
    if(action == '1') {
        switch(id) {
            case "catalogueLink":
                if(highlighted == "catalogueLinkFA") {
                    $('#dropDownList').html("<div class='dropDownLink' id='catalogueLinkFA' style='background-color: #df4e47;'><a href='catalogue.php?type=fa&p=1' id='catalogueLinkFAA' style='color: #fff'>Мебельная фурнитура</a></div>");
                } else {
					$('#dropDownList').html("<div class='dropDownLink' id='catalogueLinkFA' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkFA\", \"catalogueLinkFAA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkFA\", \"catalogueLinkFAA\")'><a href='catalogue.php?type=fa&p=1' id='catalogueLinkFAA'>Мебельная фурнитура</a></div>");
				}

				if(highlighted == "catalogueLinkEM") {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='catalogueLinkEM' style='background-color: #df4e47;'><a href='catalogue.php?type=em&p=1' id='catalogueLinkEMA' style='color: #fff'>Кромочные материалы</a></div>");
				} else {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='catalogueLinkEM' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkEM\", \"catalogueLinkEMA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkEM\", \"catalogueLinkEMA\")'><a href='catalogue.php?type=em&p=1' id='catalogueLinkEMA'>Кромочные материалы</a></div>");
				}

				if(highlighted == "catalogueLinkCA") {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='catalogueLinkCA' style='background-color: #df4e47;'><a href='catalogue.php?type=ca&p=1' id='catalogueLinkCAA' style='color: #fff'>Аксессуары для штор</a></div>");
				} else {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='catalogueLinkCA' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkCA\", \"catalogueLinkCAA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkCA\", \"catalogueLinkCAA\")'><a href='catalogue.php?type=ca&p=1' id='catalogueLinkCAA'>Аксессуары для штор</a></div>");
				}

				if(highlighted == "catalogueLinkDG") {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='catalogueLinkDG' style='background-color: #df4e47;'><a href='catalogue.php?type=dg&p=1' id='catalogueLinkDGA' style='color: #fff'>Сопутствующие товары</a></div>");
				} else {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='catalogueLinkDG' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkDG\", \"catalogueLinkDGA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkDG\", \"catalogueLinkDGA\")'><a href='catalogue.php?type=dg&p=1' id='catalogueLinkDGA'>Сопутствующие товары</a></div>");
				}

				$('#dropDownList').html($('#dropDownList').html() + "<div style='clear: both;'></div>");
                break;
            case "aboutLink":
                $('#dropDownList').html("<div class='dropDownLink' id='aboutLinkCommon' onmouseover='changeDropDownLink(\"1\", \"aboutLinkCommon\", \"aboutLinkCommonA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkCommon\", \"aboutLinkCommonA\")'><a href='about/info.php' id='aboutLinkCommonA'>Общая информация</a></div><div class='dropDownLink' id='aboutLinkAssortment' onmouseover='changeDropDownLink(\"1\", \"aboutLinkAssortment\", \"aboutLinkAssortmentA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkAssortment\", \"aboutLinkAssortmentA\")'><a href='about/assortment.php' id='aboutLinkAssortmentA'>Ассортимент</a></div><div class='dropDownLink' id='aboutLinkAwards' onmouseover='changeDropDownLink(\"1\", \"aboutLinkAwards\", \"aboutLinkAwardsA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkAwards\", \"aboutLinkAwardsA\")'><a href='about/awards.php' id='aboutLinkAwardsA'>Достижения и награды</a></div><div class='dropDownLink' id='aboutLinkGallery' onmouseover='changeDropDownLink(\"1\", \"aboutLinkGallery\", \"aboutLinkGalleryA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkGallery\", \"aboutLinkGalleryA\")'><a href='about/gallery.php' id='aboutLinkGalleryA'>Фотогалерея</a></div><div class='dropDownLink' id='aboutLinkVacancies' onmouseover='changeDropDownLink(\"1\", \"aboutLinkVacancies\", \"aboutLinkVacanciesA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkVacancies\", \"aboutLinkVacanciesA\")'><a href='about/vacancies.php' id='aboutLinkVacanciesA'>Вакансии</a></div><div style='clear: both;'></div>");
                break;
            case "storesLink":
                $('#dropDownList').html("<div class='dropDownLink' id='storesLinkCompany' onmouseover='changeDropDownLink(\"1\", \"storesLinkCompany\", \"storesLinkCompanyA\")' onmouseout='changeDropDownLink(\"0\", \"storesLinkCompany\", \"storesLinkCompanyA\")'><a href='stores/company.php' id='storesLinkCompanyA'>Фирменная сеть</a></div><div class='dropDownLink' id='storesLinkRepresentatives' onmouseover='changeDropDownLink(\"1\", \"storesLinkRepresentatives\", \"storesLinkRepresentativesA\")' onmouseout='changeDropDownLink(\"0\", \"storesLinkRepresentatives\", \"storesLinkRepresentativesA\")'><a href='stores/representatives.php' id='storesLinkRepresentativesA'>Партнёрская сеть</a></div><div style='clear: both;'></div>");
                break;
            case "partnersLink":
                $('#dropDownList').html("<div class='dropDownLink' id='partnersLinkCooperation' onmouseover='changeDropDownLink(\"1\", \"partnersLinkCooperation\", \"partnersLinkCooperationA\")' onmouseout='changeDropDownLink(\"0\", \"partnersLinkCooperation\", \"partnersLinkCooperationA\")'><a href='partners/cooperation.php' id='partnersLinkCooperationA'>Сотрудничество</a></div><div class='dropDownLink' id='partnersLinkClientNews' onmouseover='changeDropDownLink(\"1\", \"partnersLinkClientNews\", \"partnersLinkClientNewsA\")' onmouseout='changeDropDownLink(\"0\", \"partnersLinkClientNews\", \"partnersLinkClientNewsA\")'><a href='partners/news.php' id='partnersLinkClientNewsA'>Новости для клиентов</a></div><div style='clear: both;'></div>");
                break;
            case "contactsLink":
				if(highlighted == "contactsLinkStores") {
					$('#dropDownList').html("<div class='dropDownLink' id='contactsLinkStores' style='background-color: #df4e47;'><a href='contacts/stores.php' id='contactsLinkStoresA' style='color: #fff;'>Магазины</a></div>")
				} else {
					$('#dropDownList').html("<div class='dropDownLink' id='contactsLinkStores' onmouseover='changeDropDownLink(\"1\", \"contactsLinkStores\", \"contactsLinkStoresA\")' onmouseout='changeDropDownLink(\"0\", \"contactsLinkStores\", \"contactsLinkStoresA\")'><a href='contacts/stores.php' id='contactsLinkStoresA'>Магазины</a></div>");
				}

				if(highlighted == "contactsLinkMain") {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='contactsLinkMain' style='background-color: #df4e47;'><a href='contacts/main.php' id='contactsLinkMainA' style='color: #fff;'>Головное предприятие</a></div>");
				} else {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink' id='contactsLinkMain' onmouseover='changeDropDownLink(\"1\", \"contactsLinkMain\", \"contactsLinkMainA\")' onmouseout='changeDropDownLink(\"0\", \"contactsLinkMain\", \"contactsLinkMainA\")'><a href='contacts/main.php' id='contactsLinkMainA'>Головное предприятие</a></div>");
				}

				if(highlighted == "contactsLinkMail") {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink'  id='contactsLinkMail' style='background-color: #df4e47;'><a href='contacts/mail.php' id='contactsLinkMailA' style='color: #fff;'>Обратная связь</a></div><div style='clear: both;'></div>");
				} else {
					$('#dropDownList').html($('#dropDownList').html() + "<div class='dropDownLink'  id='contactsLinkMail' onmouseover='changeDropDownLink(\"1\", \"contactsLinkMail\", \"contactsLinkMailA\")' onmouseout='changeDropDownLink(\"0\", \"contactsLinkMail\", \"contactsLinkMailA\")'><a href='contacts/mail.php' id='contactsLinkMailA'>Обратная связь</a></div><div style='clear: both;'></div>");
				}
                break;
            default:
                break;
        }

        var parentOffset = parseInt(document.getElementById(id).offsetLeft);
        $('#dropDownList').offset({left: parentOffset - $('#dropDownList').width() + document.getElementById(id).offsetWidth});
        $('#dropDownArrowContainer').offset({left: parentOffset - $('#dropDownList').width() + document.getElementById(id).offsetWidth});
        $('#dropDownArrow').offset({left: parentOffset + document.getElementById(id).offsetWidth - 50});
        $('#dropDownArrowContainer').width($('#dropDownList').width());
        $('#dropDownList').show();
        $('#dropDownArrowContainer').show();
    }
}

$(document).ready(function() {
    $('#dropDownList').mouseover(function() {
        showDropDownList();
    });

    $('#dropDownArrowContainer').mouseover(function() {
        showDropDownList();
    });

    $('.menuLink').mouseover(function() {
        showDropDownList();
    });

    $('.menuLink a').mouseover(function() {
        showDropDownList();
    });

    $('.menuLink img').mouseover(function() {
        showDropDownList();
    });

    $('#dropDownList').mouseout(function() {
        hideDropDownList();
    });

    $('#dropDownArrowContainer').mouseout(function() {
        hideDropDownList();
    });

    $('.menuLink').mouseut(function() {
        hideDropDownList();
    });

    $('.menuLink a').mouseout(function() {
        hideDropDownList();
    });

    $('.menuLink img').mouseout(function() {
        hideDropDownList();
    });

    $('.menuLinkNotDD').mouseover(function() {
        hideDropDownList();
    });
});

function changeDropDownLink(action, id, text) {
    if(action == '1') {
        document.getElementById(id).style.backgroundColor = "#df4e47";
        document.getElementById(text).style.color = "#fff";
    }

    if(action == '0') {
        document.getElementById(id).style.backgroundColor = "#fff";
        document.getElementById(text).style.color = "#4c4c4c";
    }
}

function hideDropDownList() {
    $('#dropDownList').hide();
    $('#dropDownArrowContainer').hide();
}

function showDropDownList() {
    $('#dropDownList').show();
    $('#dropDownArrowContainer').show();
}

$(document).mouseup(function (e) {
    var container = $("#dropDownList");
    if (container.has(e.target).length === 0){
        container.hide();
		$("#dropDownArrowContainer").hide();
    }

	var sl = $("#searchList");
	if(document.getElementById('searchFieldInput') != document.activeElement) {
		if (sl.has(e.target).length === 0){
			sl.hide('fast');
		}
	}
});

function changeIcon(id, img, depth) {
	var d = "";

	for(var i = 0; i < depth; i++) {
		d += "../";
	}

    document.getElementById(id).src = d + "img/system/" + img;
}

$(window).on('load', function() {
	$('#searchFieldInput').on('focus', function() {
		if($('#searchFieldInput').val() == "Поиск...") {
			$('#searchFieldInput').val('');
			document.getElementById('searchFieldInput').style.color = "#4c4c4c";
		} else {
			showSearchList();
		}
	});

	$('#searchFieldInput').on('blur', function() {
		if($('#searchFieldInput').val() == '') {
			$('#searchFieldInput').val("Поиск...");
			$('#searchFieldInput').css('color', '#777;');
		}
	});

	$('#searchFieldInput').on('keyup', function() {
		if($('#searchFieldInput').val() != '') {
			showSearchList();
		} else {
			if($('#searchList').css('display') != "none") {
				$('#searchList').hide("fast");
			}
		}
	});
});

function showSearchList() {
	if($('#searchFieldInput').val() != "Поиск..." && $('#searchFieldInput').val() != "") {
		$.ajax({
			type: 'POST',
			data: {"query": $('#searchFieldInput').val()},
			url: "scripts/ajaxSearch.php",
			success: function(response) {
				$('#searchList').html(response);
				$('#searchList').show('fast');
			}
		});
	}
}

function showHideMobileMenu() {
	if($('#mobileMenu').is(':visible')) {
		$('#mobileMenu').hide('300');
	} else {
		$('#mobileMenu').show('300');
	}
}