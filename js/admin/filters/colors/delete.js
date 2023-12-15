function deleteColor() {
    if(confirm("Вы действительно хотите удалить выбранный цвет ручек?")) {
        var id = $('#colorSelect').val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/filters/colors/ajaxDeleteColor.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Цвет ручек успешно удалён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время удаления цвета ручек произошла ошибка. Попробуйте снова.", "error");
                        break;
                    default:
                        break;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
        })
    }
}