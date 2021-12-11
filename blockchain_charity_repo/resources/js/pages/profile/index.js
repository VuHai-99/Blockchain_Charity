$(function() {
    $('#btn-change-password').click(function(e) {
        var newPass = $('#new-password').val();
        var oldPassword = $('#old-password').val();
        var confirmPass = $('#confirm-password').val();
        console.log(newPass, confirmPass);
        axios.post(laroute.route('api.verify.password', {
                'password': oldPassword
            }))
            .then(function(response) {
                if (response.data.check == true) {
                    if (newPass == confirmPass) {
                        $('#form-change-password').submit();
                        $('.close-modal').click();
                    } else {
                        $('.error-confirm-password').html('Mật khẩu xác nhận không khớp');
                    }
                } else {
                    $('.error-old-password').html('Mật khẩu không chính xác');
                }
            })
    })
})