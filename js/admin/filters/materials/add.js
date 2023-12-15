function addMaterial() {
    var material = $("#materialInput").val();

    if(material !== '') {
        $.ajax({
            type: "POST",
            data: {"material": material},
            url: "/scripts/admin/filters/materials/ajaxAddMaterial.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Добавление прошло успешно.", "success");
                        break;
                    case "failed":
                        $.notify("Во время добавления произошла ошибка.", "error");
                        break;
                    case "duplicate":
                        $.notify("Такой материал уже существует.", "error");
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
        $.notify("Введите материал.", "error");
    }
}