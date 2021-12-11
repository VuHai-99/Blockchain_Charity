$(function() {
    console.log('ok');
    $("input[name='qty']").on('change', function(e) {
        console.log('ok');
        var idItem = $(this).attr('order-id');
        var qty = $(this).val();
        var price = $(this).attr('product-price');
        console.log(qty, idItem, price);
        axios.get(laroute.route('order.update', { id: idItem }), {
                params: {
                    'price': price,
                    'quantity': qty
                }
            })
            .then(function(response) {
                location.reload();
            })

    });
})