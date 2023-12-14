function deleteType() {
    if(confirm("Вы действительно хотите удалить выбранный тип ручек?")) {
        var id = $('#typeSelect').val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/filters/types/ajaxDeleteType.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Тип ручек успешно удалён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время удаления типа ручек произошла ошибка. Попробуйте снова.", "error");
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