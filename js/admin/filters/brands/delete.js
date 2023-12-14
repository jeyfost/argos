function deleteBrand() {
    if(confirm("Вы действительно хотите удалить выбранный бренд?")) {
        var id = $('#brandSelect').val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/filters/brands/ajaxDeleteBrand.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Бренд успешно удалён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время удаления бренда произошла ошибка. Попробуйте снова.", "error");
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