function deleteSize() {
    if(confirm("Вы действительно хотите удалить выбранный размер ручек?")) {
        var id = $('#sizeSelect').val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/filters/sizes/ajaxDeleteSize.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Размер ручек успешно удалён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время удаления размера ручек произошла ошибка. Попробуйте снова.", "error");
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