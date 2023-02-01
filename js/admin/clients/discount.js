function setDiscount() {
    var card = $('#cardInput').val();
    var discount = $('#discountInput').val();

    if(card !== '') {
        if(card > 0) {
            if(discount !== '') {
                if(discount >= 0 && discount <= 7) {
                    $.ajax({
                        type: "POST",
                        data: {"card": card, "discount": discount},
                        url: "/scripts/admin/clients/ajaxSetDiscount.php",
                        success: function (response) {
                            switch (response) {
                                case '"ok"':
                                    $.notify("Скидка установлена.", "success");
                                    break;
                                case '"card"':
                                    $.notify("Карта не зарегистрирована.", "info");
                                    break;
                                case '"failed"':
                                    $.notify("При обновлении скидки произошла ошибка.", "error");
                                    break;
                                default:
                                    break;
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $.notify(textStatus + "; " + errorThrown, "error");
                        }
                    });
                } else {
                    $.notify("Процент скидки должен быть в пределах от 0 до 7 процентов.", "error");
                }
            } else {
                $.notify("Введите процент скидки.", "error");
            }
        } else {
            $.notify("Номер карты не может быть отрицательным.", "error");
        }
    } else {
        $.notify("Введите номер дисконтной карты.", "error");
    }
}

function resetDiscount() {
    if(confirm("Обнулить скидки всех пользователей?")) {
        $.ajax({
            type: "POST",
            url: "/scripts/admin/clients/ajaxResetDiscount.php",
            success: function (response) {
                switch (response) {
                    case "ok":
                        break;
                    case "failed":
                        break;
                    default:
                        break;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
        });
    }
}