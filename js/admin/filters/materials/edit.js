function editMaterial() {
    var id = $('#materialSelect').val();
    var material = $('#materialInput').val();

    if(material !== "") {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "material": material
            },
            url: "/scripts/admin/filters/materials/ajaxEditMaterial.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Материал ручек успешно изменён.", "success");
                        break;
                    case "failed":
                        $.notify("Во время цвета материала ручек произошла ошибка. Попробуйте снова.");
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
        $.notify("Введите материал ручек.", "error");
    }
}