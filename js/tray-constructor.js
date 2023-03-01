let blockType = 1;
let widthVariant;
/*
jQuery(function ($) {
    function fix_size() {
        let images = $('.list-group img');
        images.each(setsize);

        function setsize() {
            let img = $(this),
                img_dom = img.get(0),
                container = img.parents('.list-group');
            if (img_dom.complete) {
                resize();
            } else img.one('load', resize);

            function resize() {
                if ((container.width() / container.height()) < (img_dom.width / img_dom.height)) {
                    img.width('100%');
                    img.height('auto');
                    return;
                }
                img.height('100%');
                img.width('auto');
            }
        }
    }
    $(window).on('resize', fix_size);
    fix_size();
});
*/
$(window).keyup(function(e){
    let target = $('.checkbox-ios input:focus');
    if (e.keyCode == 9 && $(target).length){
        $(target).parent().addClass('focused');
    }
});

$('.checkbox-ios input').focusout(function(){
    $(this).parent().removeClass('focused');
});

function checkboxClick() {
    $('#nextButton').css('display', 'none');

    if(blockType === 1) {
        blockType = 2;

        $('.widthContainer').html("<div class='wContainer' id='wContainer500' onclick='chooseWidth(\"500\", \"2\")'>500</div><div class='wContainer' id='wContainer650' onclick='chooseWidth(\"650\", \"2\")'>650</div><div class='wContainer' id='wContainer700' onclick='chooseWidth(\"700\", \"2\")'>700</div><div class='wContainer' id='wContainer750' onclick='chooseWidth(\"750\", \"2\")'>750</div><div class='wContainer' id='wContainer800' onclick='chooseWidth(\"800\", \"2\")'>800</div><div class='wContainer' id='wContainer850' onclick='chooseWidth(\"850\", \"2\")'>850</div><div class='wContainer' id='wContainer900' onclick='chooseWidth(\"900\", \"2\")'>900</div><div class='wContainer' id='wContainer950' onclick='chooseWidth(\"950\", \"2\")'>950</div><div class='wContainer' id='wContainer1000' onclick='chooseWidth(\"1000\", \"2\")'>1000</div><div class='wContainer' id='wContainer1050' onclick='chooseWidth(\"1050\", \"2\")'>1050</div><div class='wContainer' id='wContainer1100' onclick='chooseWidth(\"1100\", \"2\")'>1100</div><div class='wContainer' id='wContainer1150' onclick='chooseWidth(\"1150\", \"2\")'>1150</div><div class='wContainer' id='wContainer1200' onclick='chooseWidth(\"1200\", \"2\")'>1200</div><div class='wContainer' id='wContainer1250' onclick='chooseWidth(\"1250\", \"2\")'>1250</div>");
    } else {
        blockType = 1;

        $('.widthContainer').html("<div class='wContainer' id='wContainer450' onclick='chooseWidth(\"450\", \"1\")'>450</div><div class='wContainer' id='wContainer500' onclick='chooseWidth(\"500\", \"1\")'>500</div><div class='wContainer' id='wContainer550' onclick='chooseWidth(\"550\", \"1\")'>550</div><div class='wContainer' id='wContainer600' onclick='chooseWidth(\"600\", \"1\")'>600</div><div class='wContainer' id='wContainer650' onclick='chooseWidth(\"650\", \"1\")'>650</div><div class='wContainer' id='wContainer700' onclick='chooseWidth(\"700\", \"1\")'>700</div><div class='wContainer' id='wContainer750' onclick='chooseWidth(\"750\", \"1\")'>750</div><div class='wContainer' id='wContainer800' onclick='chooseWidth(\"800\", \"1\")'>800</div><div class='wContainer' id='wContainer850' onclick='chooseWidth(\"850\", \"1\")'>850</div><div class='wContainer' id='wContainer900' onclick='chooseWidth(\"900\", \"1\")'>900</div><div class='wContainer' id='wContainer950' onclick='chooseWidth(\"950\", \"1\")'>950</div><div class='wContainer' id='wContainer1000' onclick='chooseWidth(\"1000\", \"1\")'>1000</div><div class='wContainer' id='wContainer1050' onclick='chooseWidth(\"1050\", \"1\")'>1050</div><div class='wContainer' id='wContainer1100' onclick='chooseWidth(\"1100\", \"1\")'>1100</div><div class='wContainer' id='wContainer1150' onclick='chooseWidth(\"1150\", \"1\")'>1150</div><div class='wContainer' id='wContainer1200' onclick='chooseWidth(\"1200\", \"1\")'>1200</div><div class='wContainer' id='wContainer1250' onclick='chooseWidth(\"1250\", \"1\")'>1250</div><div class='wContainer' id='wContainer1350' onclick='chooseWidth(\"1350\", \"1\")'>1350</div>");
    }
}

function chooseWidth(w) {
    let id = 'wContainer' + w;
    
    widthVariant = w;

    $('#wContainer450').css('background-color', '#fff');
    $('#wContainer500').css('background-color', '#fff');
    $('#wContainer550').css('background-color', '#fff');
    $('#wContainer600').css('background-color', '#fff');
    $('#wContainer650').css('background-color', '#fff');
    $('#wContainer700').css('background-color', '#fff');
    $('#wContainer750').css('background-color', '#fff');
    $('#wContainer800').css('background-color', '#fff');
    $('#wContainer850').css('background-color', '#fff');
    $('#wContainer900').css('background-color', '#fff');
    $('#wContainer950').css('background-color', '#fff');
    $('#wContainer1000').css('background-color', '#fff');
    $('#wContainer1050').css('background-color', '#fff');
    $('#wContainer1100').css('background-color', '#fff');
    $('#wContainer1150').css('background-color', '#fff');
    $('#wContainer1200').css('background-color', '#fff');
    $('#wContainer1250').css('background-color', '#fff');
    $('#wContainer1350').css('background-color', '#fff');

    $('#' + id).css('background-color', '#d5d5d5');

    $('#nextButton').css("display", "block");
}

function showLayout() {
    $('#catalogueContent').html("" +
        "<hr />" +
        "<span class=\"breadCrumbsText\" onclick=\"resetConstructor()\">Выбор комплектации и ширины ящика</span> > <span class='breadCrumbsText' style='cursor: default;'>Расстановка модулей</span>" +
        "<br /><br />" +
        "");

    let content = $('#catalogueContent').html();

    switch(blockType) {
        case 1:
            switch(widthVariant) {
                case '450':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 450 мм</h3></div>" +
                    "");

                    let constructor450 = document.getElementById('tray-list');
                    new Sortable(constructor450, {
                        animation: 200
                    });
                    break;
                case '500':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 500 мм</h3></div>" +
                        "");

                    let constructor500 = document.getElementById('tray-list');
                    new Sortable(constructor500, {
                        animation: 200
                    });
                    break;
                case '550':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 550 мм</h3></div>" +
                        "");

                    let constructor550 = document.getElementById('tray-list');
                    new Sortable(constructor550, {
                        animation: 200
                    });
                    break;
                case '600':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 600 мм</h3></div>" +
                        "");

                    let constructor600 = document.getElementById('tray-list');
                    new Sortable(constructor600, {
                        animation: 200
                    });
                    break;
                case '650':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 650 мм</h3></div>" +
                        "");

                    let constructor650 = document.getElementById('tray-list');
                    new Sortable(constructor650, {
                        animation: 200
                    });
                    break;
                case '700':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 700 мм</h3></div>" +
                        "");

                    let constructor700 = document.getElementById('tray-list');
                    new Sortable(constructor700, {
                        animation: 200
                    });
                    break;
                case '750':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 750 мм</h3></div>" +
                        "");

                    let constructor750 = document.getElementById('tray-list');
                    new Sortable(constructor750, {
                        animation: 200
                    });
                    break;
                case '800':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 800 мм</h3></div>" +
                        "");

                    let constructor800 = document.getElementById('tray-list');
                    new Sortable(constructor800, {
                        animation: 200
                    });
                    break;
                case '850':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 850 мм</h3></div>" +
                        "");

                    let constructor850 = document.getElementById('tray-list');
                    new Sortable(constructor850, {
                        animation: 200
                    });
                    break;
                case '900':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 900 мм</h3></div>" +
                        "");

                    let constructor900 = document.getElementById('tray-list');
                    new Sortable(constructor900, {
                        animation: 200
                    });
                    break;
                case '950':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 950 мм</h3></div>" +
                        "");

                    let constructor950 = document.getElementById('tray-list');
                    new Sortable(constructor950, {
                        animation: 200
                    });
                    break;
                case '1000':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1000 мм</h3></div>" +
                        "");

                    let constructor1000 = document.getElementById('tray-list');
                    new Sortable(constructor1000, {
                        animation: 200
                    });
                    break;
                case '1050':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1050 мм</h3></div>" +
                        "");

                    let constructor1050 = document.getElementById('tray-list');
                    new Sortable(constructor1050, {
                        animation: 200
                    });
                    break;
                case '1100':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1100 мм</h3></div>" +
                        "");

                    let constructor1100 = document.getElementById('tray-list');
                    new Sortable(constructor1100, {
                        animation: 200
                    });
                    break;
                case '1150':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1150 мм</h3></div>" +
                        "");

                    let constructor1150 = document.getElementById('tray-list');
                    new Sortable(constructor1150, {
                        animation: 200
                    });
                    break;
                case '1200':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray8' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray8\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1200 мм</h3></div>" +
                        "");

                    let constructor1200 = document.getElementById('tray-list');
                    new Sortable(constructor1200, {
                        animation: 200
                    });
                    break;
                case '1250':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray8' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray8\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1250 мм</h3></div>" +
                        "");

                    let constructor1250 = document.getElementById('tray-list');
                    new Sortable(constructor1250, {
                        animation: 200
                    });
                    break;
                case '1350':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray2' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange1' onmouseover='changeIcon(\"imgChange1\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange1\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray2\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray8' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray8\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange2' onmouseover='changeIcon(\"imgChange2\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange2\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1350 мм</h3></div>" +
                        "");

                    let constructor1350 = document.getElementById('tray-list');
                    new Sortable(constructor1350, {
                        animation: 200
                    });
                    break;
                default:
                    break;
            }
            break;
        case 2:
            switch (widthVariant) {
                case '500':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 500 мм</h3></div>" +
                        "");

                    let constructor500 = document.getElementById('tray-list');
                    new Sortable(constructor500, {
                        animation: 200
                    });
                    break;
                case '650':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 650 мм</h3></div>" +
                        "");

                    let constructor650 = document.getElementById('tray-list');
                    new Sortable(constructor650, {
                        animation: 200
                    });
                    break;
                case '700':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 700 мм</h3></div>" +
                        "");

                    let constructor700 = document.getElementById('tray-list');
                    new Sortable(constructor700, {
                        animation: 200
                    });
                    break;
                case '750':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 750 мм</h3></div>" +
                        "");

                    let constructor750 = document.getElementById('tray-list');
                    new Sortable(constructor750, {
                        animation: 200
                    });
                    break;
                case '800':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 800 мм</h3></div>" +
                        "");

                    let constructor800 = document.getElementById('tray-list');
                    new Sortable(constructor800, {
                        animation: 200
                    });
                    break;
                case '850':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 850 мм</h3></div>" +
                        "");

                    let constructor850 = document.getElementById('tray-list');
                    new Sortable(constructor850, {
                        animation: 200
                    });
                    break;
                case '900':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 900 мм</h3></div>" +
                        "");

                    let constructor900 = document.getElementById('tray-list');
                    new Sortable(constructor900, {
                        animation: 200
                    });
                    break;
                case '950':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 950 мм</h3></div>" +
                        "");

                    let constructor950 = document.getElementById('tray-list');
                    new Sortable(constructor950, {
                        animation: 200
                    });
                    break;
                case '1000':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1000 мм</h3></div>" +
                        "");

                    let constructor1000 = document.getElementById('tray-list');
                    new Sortable(constructor1000, {
                        animation: 200
                    });
                    break;
                case '1050':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1050 мм</h3></div>" +
                        "");

                    let constructor1050 = document.getElementById('tray-list');
                    new Sortable(constructor1050, {
                        animation: 200
                    });
                    break;
                case '1100':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1100 мм</h3></div>" +
                        "");

                    let constructor1100 = document.getElementById('tray-list');
                    new Sortable(constructor1100, {
                        animation: 200
                    });
                    break;
                case '1150':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1150 мм</h3></div>" +
                        "");

                    let constructor1150 = document.getElementById('tray-list');
                    new Sortable(constructor1150, {
                        animation: 200
                    });
                    break;
                case '1200':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1200 мм</h3></div>" +
                        "");

                    let constructor1200 = document.getElementById('tray-list');
                    new Sortable(constructor1200, {
                        animation: 200
                    });
                    break;
                case '1250':
                    $('#catalogueContent').html(content + "" +
                        "<div class='list-group' id='tray-list'>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray3' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange3' onmouseover='changeIcon(\"imgChange3\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange3\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray3\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne107GR.jpg' class='constructorIMG' id='tray4' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange4' onmouseover='changeIcon(\"imgChange4\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange4\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray4\", \"107\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayBaseGR.jpg' class='constructorIMG' id='tray1' /></div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray5' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange5' onmouseover='changeIcon(\"imgChange5\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange5\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray5\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray6' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange6' onmouseover='changeIcon(\"imgChange6\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange6\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray6\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'>" +
                        "<img src='/img/catalogue/constructor/tray/trayOne157GR.jpg' class='constructorIMG' id='tray7' type='1' />" +
                        "<div class='imgChangeIconContainer'>" +
                        "<img src='/img/system/imgChangeIconBlack.png' class='imgChangeIcon' id='imgChange7' onmouseover='changeIcon(\"imgChange7\", \"imgChangeIconRed.png\")' onmouseout='changeIcon(\"imgChange7\", \"imgChangeIconBlack.png\")' onclick='changeTrayType(\"tray7\", \"157\")' />" +
                        "</div>" +
                        "</div>" +
                        "<div class='list-group-item'><img src='/img/catalogue/constructor/tray/trayKnifeGR.jpg' class='constructorIMG' id='tray2' /></div>" +
                        "<div style='clear: both;'></div>" +
                        "</div>" +
                        "<div class='list-group'><h3>Ширина ящика: 1250 мм</h3></div>" +
                        "");

                    let constructor1250 = document.getElementById('tray-list');
                    new Sortable(constructor1250, {
                        animation: 200
                    });
                    break;
                default:
                    break;
            }
            break;
        default:
            break;
    }
}

function resetConstructor() {
    blockType = 1;
    widthVariant = '';

    $('#catalogueContent').html("" +
        "<hr />" +
        "<span class=\"breadCrumbsText\" onclick=\"resetConstructor()\">Выбор комплектации и ширины ящика</span>" +
        "<p><b>Комплектация:</b></p>" +
        "<span>Без блока под ножи</span>&nbsp;" +
        "<label class=\"checkbox-ios\">" +
        "<input type=\"checkbox\" onclick=\"checkboxClick()\">" +
        "<span class=\"checkbox-ios-switch\"></span>" +
        "</label>" +
        "<span>C блоком под ножи</span>" +
        "<p><b>Ширина ящика:</b></p>" +
        "<div class=\"widthContainer\">" +
        "<div class=\"wContainer\" id=\"wContainer450\" onclick=\"chooseWidth('450', '1')\">450</div>" +
        "<div class=\"wContainer\" id=\"wContainer500\" onclick=\"chooseWidth('500', '1')\">500</div>" +
        "<div class=\"wContainer\" id=\"wContainer550\" onclick=\"chooseWidth('550', '1')\">550</div>" +
        "<div class=\"wContainer\" id=\"wContainer600\" onclick=\"chooseWidth('600', '1')\">600</div>" +
        "<div class=\"wContainer\" id=\"wContainer650\" onclick=\"chooseWidth('650', '1')\">650</div>" +
        "<div class=\"wContainer\" id=\"wContainer700\" onclick=\"chooseWidth('700', '1')\">700</div>" +
        "<div class=\"wContainer\" id=\"wContainer750\" onclick=\"chooseWidth('750', '1')\">750</div>" +
        "<div class=\"wContainer\" id=\"wContainer800\" onclick=\"chooseWidth('800', '1')\">800</div>" +
        "<div class=\"wContainer\" id=\"wContainer850\" onclick=\"chooseWidth('850', '1')\">850</div>" +
        "<div class=\"wContainer\" id=\"wContainer900\" onclick=\"chooseWidth('900', '1')\">900</div>" +
        "<div class=\"wContainer\" id=\"wContainer950\" onclick=\"chooseWidth('950', '1')\">950</div>" +
        "<div class=\"wContainer\" id=\"wContainer1000\" onclick=\"chooseWidth('1000', '1')\">1000</div>" +
        "<div class=\"wContainer\" id=\"wContainer1050\" onclick=\"chooseWidth('1050', '1')\">1050</div>" +
        "<div class=\"wContainer\" id=\"wContainer1100\" onclick=\"chooseWidth('1100', '1')\">1100</div>" +
        "<div class=\"wContainer\" id=\"wContainer1150\" onclick=\"chooseWidth('1150', '1')\">1150</div>" +
        "<div class=\"wContainer\" id=\"wContainer1200\" onclick=\"chooseWidth('1200', '1')\">1200</div>" +
        "<div class=\"wContainer\" id=\"wContainer1250\" onclick=\"chooseWidth('1250', '1')\">1250</div>" +
        "<div class=\"wContainer\" id=\"wContainer1350\" onclick=\"chooseWidth('1350', '1')\">1350</div>" +
        "</div>" +
        "<div class=\"boxIMGContainer\">" +
        "<img src=\"/img/system/box.jpg\" />" +
        "<br />" +
        "<div class=\"personalMenuLink\" id=\"nextButton\" onmouseover=\"buttonChange('nextButton', 1)\" onmouseout=\"buttonChange('nextButton', 0)\" onclick=\"showLayout()\">Далее</div>" +
        "</div>" +
        "");
}

function changeTrayType(id, size) {
    var type = $('#' + id).attr('type');

    switch(type) {
        case '1':
            $('#' + id).attr('src', '/img/catalogue/constructor/tray/trayTwo' + size + 'GR.jpg');
            $('#' + id).attr('type', '2');
            break;
        case '2':
            $('#' + id).attr('src', '/img/catalogue/constructor/tray/trayThree' + size + 'GR.jpg');
            $('#' + id).attr('type', '3');
            break;
        case '3':
            $('#' + id).attr('src', '/img/catalogue/constructor/tray/trayOne' + size + 'GR.jpg');
            $('#' + id).attr('type', '1');
            break;
        default:
            break;
    }
}