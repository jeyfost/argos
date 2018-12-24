$(window).load(function() {
	$('#registrationDescription').width(parseInt($('#registrationBlock').width() - $('#registrationContainer').width() - 50));
});

function registerCheck() {
	if(document.getElementById('registerLoginInput').value === '' || document.getElementById('registerPasswordInput').value === '') {
		document.getElementById('registerStatus').innerHTML = "<span style='color: #ff282b; font-size: 16px; font-style: italic;'>Заполните все текстовые поля.</span><br/><br/>";
		return false;
	}

	return true;
}
