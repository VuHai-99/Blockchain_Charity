$(function() {
    $('.donate-once').click(function() {
        $('.donate-monthly').removeClass('action-donator');
        $('.donate-monthly').css('background-color', '#484646');
        $(this).addClass('action-donator');
        $('#top-donator').show();
        $('#monthly-donator').hide();
    })

    $('.donate-monthly').click(function() {
        $('.donate-once').removeClass('action-donator');
        $('.donate-once').css('background-color', '#484646');
        $(this).addClass('action-donator');
        $('#top-donator').hide();
        $('#monthly-donator').show();
    })
})