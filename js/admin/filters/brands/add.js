function addBrand() {
    var name = $("#nameInput").val();

    if(name !== '') {
        $.ajax({
            type: "POST",
            data: {"name": name},
            url: "/scripts/admin/filters/brands/ajaxAddBrand.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Добавление прошло успешно.", "success");
                        break;
                    case "failed":
                        $.notify("Во время добавления произошла ошибка.", "error");
                        break;
                    case "duplicate":
                        $.notify("Такой бренд уже существует.", "error");
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
        $.notify("Введите название бренда.", "error");
    }
}