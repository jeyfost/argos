function addColor() {
    var color = $("#colorInput").val();

    if(color !== '') {
        $.ajax({
            type: "POST",
            data: {"color": color},
            url: "/scripts/admin/filters/colors/ajaxAddColor.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Добавление прошло успешно.", "success");
                        break;
                    case "failed":
                        $.notify("Во время добавления произошла ошибка.", "error");
                        break;
                    case "duplicate":
                        $.notify("Такой цвет уже существует.", "error");
                        break;
                    default:
                        $.notify(response, "warn");
                        break;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
        });
    } else {
        $.notify("Введите цвет.", "error");
    }
}