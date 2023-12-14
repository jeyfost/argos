function editSize() {
    var id = $('#sizeSelect').val();
    var size = $('#sizeInput').val();

    if(size !== "") {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "size": size
            },
            url: "/scripts/admin/filters/sizes/ajaxEditSize.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Размер ручек успешно изменён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время редактирования размера ручек произошла ошибка. Попробуйте снова.");
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
        $.notify("Введите размер ручек.", "error");
    }
}