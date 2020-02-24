function changeQuantity(id) {
    var input = "quantityInput" + id;
    var quantity = $('#' + input).val();

    if (quantity !== '' && quantity > 0) {
        $.ajax({
            type: "POST",
            data: {
                "id": id,
                "quantity": quantity
            },
            url: "/scripts/personal/ajaxChangeQuantity.php",
            success: function (response) {
                $('#totalPriceText').html(response);

                $.ajax({
                    type: "POST",
                    url: "/scripts/personal/ajaxBasketCalculatePriceBeforeDiscount.php",
                    success: function (priceWOD) {
                        $('#totalPriceWODText').html(priceWOD);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.notify(textStatus + "; " + errorThrown, "error");
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(textStatus + "; " + errorThrown, "error");
            }
        });
    }
}