function deleteEmployee() {
    if(confirm("Вы действительно хотите удалить данные сотрудника?")) {
        var id = $('#employeeSelect').val();

        $.ajax({
            type: "POST",
            data: {"id": id},
            url: "/scripts/admin/employees/ajaxDeleteEmployee.php",
            success: function (response) {
                switch(response) {
                    case "ok":
                        $.notify("Данные сотрудника были успешно удалены.", "success");
                        break;
                    case "failed":
                        $.notify("Во время удаления данных сотрудника произошла ошибка. Попробуйте снова.", "error");
                        break;
                    default:
                        break;
                }
            }
        })
    }
}