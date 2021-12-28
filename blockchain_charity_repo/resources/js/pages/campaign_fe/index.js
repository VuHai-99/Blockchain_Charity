$(function() {
    $(`input[name='donate']`).keypress(function(e) {
        if (e.keyCode == 13) {
            window.location.replace(laroute.route('login'));
        }
    })

    $('#btn_donate').click(function(e) {
        window.location.replace(laroute.route('login'));
    })
})