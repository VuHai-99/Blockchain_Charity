$(function() {
    $(`input[name='quantity']`).change(function() {
        var qty = $(this).val();
        var objTotal = $(this).parents('.modal-body').find('.total_money');
        console.log(objTotal);
        var price = objTotal.attr('product-price');
        var total = Number(qty) * Number(price);
        console.log(price, total);
        objTotal.html(total);
    })
})