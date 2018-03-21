function loginCheck() {
	if(document.getElementById('loginLoginInput').value === '' || document.getElementById('loginPasswordInput').value === '') {
		document.getElementById('loginStatus').innerHTML = "<span style='color: #df4e47; font-size: 16px; font-style: italic;'>Заполните все текстовые поля.</span><br/><br/>";
		return false;
	}

	return true;
}