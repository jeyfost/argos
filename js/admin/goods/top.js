function changeTopQuantity(quantityOnThePage) {
    var quantity = $('#quantityInput').val();

    if(quantity <= 0) {
        quantity = 1;
    }

    if(quantity !== quantityOnThePage) {
        window.location.href="/admin/goods/top.php?quantity=" + quantity;
    }
}