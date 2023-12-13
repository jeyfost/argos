function editBrand() {
    var id = $('#brandSelect').val();
    var name = $('#nameInput').val();

    if(name !== "") {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "name": name
            },
            url: "/scripts/admin/filters/brands/ajaxEditBrand.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Название бренда успешно изменено.", "success");
                        break;
                    case "failed":
                        $.notify("Во время редактирования названия бренда произошла ошибка. Попробуйте снова.");
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
        $.notify("Введите название бренда.", "error");
    }
}