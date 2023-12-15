function editColor() {
    var id = $('#colorSelect').val();
    var color = $('#colorInput').val();

    if(color !== "") {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "color": color
            },
            url: "/scripts/admin/filters/colors/ajaxEditColor.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Цвет ручек успешно изменён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время цвета размера ручек произошла ошибка. Попробуйте снова.");
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
        $.notify("Введите цвет ручек.", "error");
    }
}