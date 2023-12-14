function addSize() {
    var size = $("#sizeInput").val();

    if(size !== '') {
        $.ajax({
            type: "POST",
            data: {"size": size},
            url: "/scripts/admin/filters/sizes/ajaxAddSize.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Добавление прошло успешно.", "success");
                        break;
                    case "failed":
                        $.notify("Во время добавления произошла ошибка.", "error");
                        break;
                    case "duplicate":
                        $.notify("Такой размер уже существует.", "error");
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
        $.notify("Введите размер.", "error");
    }
}