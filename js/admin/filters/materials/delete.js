function deleteMaterial() {
    if(confirm("Вы действительно хотите удалить выбранный материал ручек?")) {
        var id = $('#materialSelect').val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/filters/materials/ajaxDeleteMaterial.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Материал ручек успешно удалён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время удаления материала ручек произошла ошибка. Попробуйте снова.", "error");
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