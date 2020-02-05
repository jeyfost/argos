function searchItemHover(id, action, parameter) {
    if(action === 1) {
        $('#' + id).css('background-color', '#c0cdd6');
    } else {
        if(parameter % 2) {
            $('#' + id).css('background-color', '#fff');
        } else {
            $('#' + id).css('background-color', '#d9d9d9');
        }
    }
}