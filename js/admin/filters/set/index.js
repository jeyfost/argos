function setFilters() {
    let handle = $('#handleSelect').val();
    let material = $('#materialSelect').val();
    let type = $('#typeSelect').val();
    let color = $('#colorSelect').val();
    let brand = $('#brandSelect').val();
    let size = $('#sizeSelect').val();

    $.ajax({
        type: "POST",
        data: {
            "handle": handle,
            "material": material,
            "type": type,
            "color": color,
            "brand": brand,
            "size": size
        },
        url: "/scripts/admin/filters/set/ajaxSetFilters.php",
        success: function (response) {
            switch(response) {
                case "ok":
                    $.notify("Фильтры успешно установлены.", "success");
                    break;
                case "failed":
                    $.notify("Во время установки фильтров произошла ошибка. Попробуйте снова.", "error");
                    break;
                case "size":
                    $.notify("У выбранного типа ручек не может быть присадочного размера.", "error");
                    break;
                case "empty":
                    $.notify("Не установлен размер ручки.", "error");
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

function setNewFiltersWithSize() {
    let handle = $('#handleSelect').val();
    let material = $('#materialSelect').val();
    let type = $('#typeSelect').val();
    let color = $('#colorSelect').val();
    let brand = $('#brandSelect').val();
    let size = $('#sizeSelect').val();

    if(size !== '') {
        if(material !== '') {
            if(color !== '') {
                if(brand !== '') {
                    $.ajax({
                        type: "POST",
                        data: {
                            "handle": handle,
                            "material": material,
                            "type": type,
                            "color": color,
                            "brand": brand,
                            "size": size
                        },
                        url: "/scripts/admin/filters/set/ajaxSetNewFiltersWithSize.php",
                        success: function (response) {
                            switch(response) {
                                case "ok":
                                    $.notify("Фильтры успешно установлены.", "success");
                                    break;
                                case "failed":
                                    $.notify("Во время установки фильтров произошла ошибка. Попробуйте снова.", "error");
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
                    $.notify("Укажите бренд ручки.", "error");
                }
            } else {
                $.notify("Укажите цвет ручки.", "error");
            }
        } else {
            $.notify("Укажите материал ручки.", "error");
        }
    } else {
        $.notify("Укажите размер ручки.", "error");
    }
}

function setNewFiltersWithoutSize() {
    let handle = $('#handleSelect').val();
    let material = $('#materialSelect').val();
    let type = $('#typeSelect').val();
    let color = $('#colorSelect').val();
    let brand = $('#brandSelect').val();

    if(material !== '') {
        if(color !== '') {
            if(brand !== '') {
                $.ajax({
                    type: "POST",
                    data: {
                        "handle": handle,
                        "material": material,
                        "type": type,
                        "color": color,
                        "brand": brand
                    },
                    url: "/scripts/admin/filters/set/ajaxSetNewFiltersWithoutSize.php",
                    success: function (response) {
                        switch(response) {
                            case "ok":
                                $.notify("Фильтры успешно установлены.", "success");
                                break;
                            case "failed":
                                $.notify("Во время установки фильтров произошла ошибка. Попробуйте снова.", "error");
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
                $.notify("Укажите бренд ручки.", "error");
            }
        } else {
            $.notify("Укажите цвет ручки.", "error");
        }
    } else {
        $.notify("Укажите материал ручки.", "error");
    }
}
