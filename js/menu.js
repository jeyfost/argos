function showDropdownList(action, id) {
    if(action == '1') {
        switch(id) {
            case "catalogueLink":
                $('#dropDownList').html("<div class='dropDownLink' id='catalogueLinkFA' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkFA\", \"catalogueLinkFAA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkFA\", \"catalogueLinkFAA\")'><a href='catalogue.php?type=fa&p=1' id='catalogueLinkFAA'>Мебельная фурнитура</a></div><div class='dropDownLink' id='catalogueLinkEM' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkEM\", \"catalogueLinkEMA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkEM\", \"catalogueLinkEMA\")'><a href='catalogue.php?type=em&p=1' id='catalogueLinkEMA'>Кромочные материалы</a></div><div class='dropDownLink' id='catalogueLinkCA' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkCA\", \"catalogueLinkCAA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkCA\", \"catalogueLinkCAA\")'><a href='catalogue.php?type=сa&p=1' id='catalogueLinkCAA'>Аксессуары для штор</a></div><div class='dropDownLink' id='catalogueLinkDG' onmouseover='changeDropDownLink(\"1\", \"catalogueLinkDG\", \"catalogueLinkDGA\")' onmouseout='changeDropDownLink(\"0\", \"catalogueLinkDG\", \"catalogueLinkDGA\")'><a href='catalogue.php?type=dg&p=1' id='catalogueLinkDGA'>Сопутствующие товары</a></div><div style='clear: both;'></div>");
                break;
            case "aboutLink":
                $('#dropDownList').html("<div class='dropDownLink' id='aboutLinkCommon' onmouseover='changeDropDownLink(\"1\", \"aboutLinkCommon\", \"aboutLinkCommonA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkCommon\", \"aboutLinkCommonA\")'><a href='about.php?page=common' id='aboutLinkCommonA'>Общая информация</a></div><div class='dropDownLink' id='aboutLinkAssortment' onmouseover='changeDropDownLink(\"1\", \"aboutLinkAssortment\", \"aboutLinkAssortmentA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkAssortment\", \"aboutLinkAssortmentA\")'><a href='about.php?page=assortment' id='aboutLinkAssortmentA'>Ассортимент</a></div><div class='dropDownLink' id='aboutLinkAwards' onmouseover='changeDropDownLink(\"1\", \"aboutLinkAwards\", \"aboutLinkAwardsA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkAwards\", \"aboutLinkAwardsA\")'><a href='about.php?page=awards' id='aboutLinkAwardsA'>Достижения и награды</a></div><div class='dropDownLink' id='aboutLinkGallery' onmouseover='changeDropDownLink(\"1\", \"aboutLinkGallery\", \"aboutLinkGalleryA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkGallery\", \"aboutLinkGalleryA\")'><a href='about.php?page=gallery' id='aboutLinkGalleryA'>Фотогаллерея</a></div><div class='dropDownLink' id='aboutLinkVacancies' onmouseover='changeDropDownLink(\"1\", \"aboutLinkVacancies\", \"aboutLinkVacanciesA\")' onmouseout='changeDropDownLink(\"0\", \"aboutLinkVacancies\", \"aboutLinkVacanciesA\")'><a href='about.php?page=vacancies' id='aboutLinkVacanciesA'>Вакансии</a></div><div style='clear: both;'></div>");
                break;
            case "storesLink":
                $('#dropDownList').html("<div class='dropDownLink' id='storesLinkCompany' onmouseover='changeDropDownLink(\"1\", \"storesLinkCompany\", \"storesLinkCompanyA\")' onmouseout='changeDropDownLink(\"0\", \"storesLinkCompany\", \"storesLinkCompanyA\")'><a href='stores.php?page=company' id='storesLinkCompanyA'>Фирменная сеть</a></div><div class='dropDownLink' id='storesLinkRepresentatives' onmouseover='changeDropDownLink(\"1\", \"storesLinkRepresentatives\", \"storesLinkRepresentativesA\")' onmouseout='changeDropDownLink(\"0\", \"storesLinkRepresentatives\", \"storesLinkRepresentativesA\")'><a href='stores.php?page=representatives' id='storesLinkRepresentativesA'>Партнёрская сеть</a></div><div style='clear: both;'></div>");
                break;
            case "partnersLink":
                $('#dropDownList').html("<div class='dropDownLink' id='partnersLinkCooperation' onmouseover='changeDropDownLink(\"1\", \"partnersLinkCooperation\", \"partnersLinkCooperationA\")' onmouseout='changeDropDownLink(\"0\", \"partnersLinkCooperation\", \"partnersLinkCooperationA\")'><a href='partners.php?page=cooperation' id='partnersLinkCooperationA'>Сотрудничество</a></div><div class='dropDownLink' id='partnersLinkClientNews' onmouseover='changeDropDownLink(\"1\", \"partnersLinkClientNews\", \"partnersLinkClientNewsA\")' onmouseout='changeDropDownLink(\"0\", \"partnersLinkClientNews\", \"partnersLinkClientNewsA\")'><a href='partners.php?page=clientsnews' id='partnersLinkClientNewsA'>Новости для клиентов</a></div><div style='clear: both;'></div>");
                break;
            case "contactsLink":
                $('#dropDownList').html("<div class='dropDownLink' id='contactsLinkStores' onmouseover='changeDropDownLink(\"1\", \"contactsLinkStores\", \"contactsLinkStoresA\")' onmouseout='changeDropDownLink(\"0\", \"contactsLinkStores\", \"contactsLinkStoresA\")'><a href='contacts.php?page=stores' id='contactsLinkStoresA'>Магазины</a></div><div class='dropDownLink' id='contactsLinkMain' onmouseover='changeDropDownLink(\"1\", \"contactsLinkMain\", \"contactsLinkMainA\")' onmouseout='changeDropDownLink(\"0\", \"contactsLinkMain\", \"contactsLinkMainA\")'><a href='contacts.php?page=main' id='contactsLinkMainA'>Головное предприятие</a></div><div class='dropDownLink'  id='contactsLinkMail' onmouseover='changeDropDownLink(\"1\", \"contactsLinkMail\", \"contactsLinkMailA\")' onmouseout='changeDropDownLink(\"0\", \"contactsLinkMail\", \"contactsLinkMailA\")'><a href='contacts.php?page=mail' id='contactsLinkMailA'>Обратная связь</a></div><div style='clear: both;'></div>");
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
});

function changeIcon(id, img, depth) {
	var d = "";

	for(var i = 0; i < depth; i++) {
		d += "../";
	}

    document.getElementById(id).src = d + "img/system/" + img;
}