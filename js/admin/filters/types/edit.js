function editType() {
    var id = $('#typeSelect').val();
    var name = $('#typeInput').val();

    if(name !== "") {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "name": name
            },
            url: "/scripts/admin/filters/types/ajaxEditType.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Название типа ручек успешно изменено.", "success");
                        break;
                    case "failed":
                        $.notify("Во время редактирования названия типа ручек произошла ошибка. Попробуйте снова.");
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
        $.notify("Введите название типа ручек.", "error");
    }
}