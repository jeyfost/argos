function editEmployee() {
    var id = $('#employeeSelect').val();
    var fullName = $('#fullNameInput').val();
    var name = $('#nameInput').val();
    var position = $('#positionInput').val();
    var phone = $('#phoneInput').val();

    if(fullName !== '') {
        if(name !== '') {
            if(position !== '') {
                if(phone !== '') {
                    $.ajax({
                        type: "POST",
                        data: {
                            "id": id,
                            "fullName": fullName,
                            "name": name,
                            "position": position,
                            "phone": phone
                        },
                        url: "/scripts/admin/employees/ajaxEditEmployee.php",
                        success: function(response) {
                            switch(response) {
                                case "ok":
                                    $.notify("Данные сотрудника успешно изменены.", "success");
                                    break;
                                case "failed":
                                    $.notify("Во время редактирования данных сотрудника произошла ошибка. Попробуйте снова.");
                                    break;
                                default:
                                    break;
                            }
                        }
                    });
                } else {
                    $.notify("Введите номер телефона сотрудника.", "error");
                }
            } else {
                $.notify("Введите должность сотрудника.", "error");
            }
        } else {
            $.notify("Введите имя сотрудника.", "error");
        }
    } else {
        $.notify("Введите ФИО сотрудника.", "error");
    }
}