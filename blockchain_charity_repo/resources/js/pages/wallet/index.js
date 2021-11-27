$(function() {
    var check = false;
    var otpUser;
    $('.fa-eye').on('click', function() {
        let input = $(`input[name='private_key']`);
        input.attr('type', 'password');
        $(this).hide();
        $('.fa-eye-slash').show();
    })
    $('#confirm-password').submit(function(e) {
        e.preventDefault();
        var password = $(`input[name='password']`).val();
        axios.post(laroute.route('api.verify.password', {
                'password': password
            }))
            .then(function(response) {
                if (response.data.check == true) {
                    $(`input[name='password']`).val('');
                    axios.get(laroute.route('api.send.otp'))
                        .then(function(response) {
                            otpUser = response.data.otp;
                        });
                    $('.fa-eye-slash').click();
                    $('#control-modal-otp').click();
                } else {
                    $('.error-password').html('Mật khẩu không chính xác');
                }
            })
    })

    $('#confirm-otp').submit(function(e) {
        e.preventDefault();
        var otp = $(`input[name='otp']`).val();
        if (otp != otpUser) {
            $('.error-otp').html("Mã OTP không chính xác.");
            setTimeout(function() {
                $('#control-modal-otp').click();
                $('.modal-backdrop').hide();

            }, 1000);
        } else {
            $(`input[name='otp']`).val('');
            $('#control-modal-otp').click();
            $('.modal-backdrop').hide();
            $(`input[name='private_key']`).attr('type', 'text');
            $('.fa-eye-slash').hide();
            $('.fa-eye').show();
            check = true;
        }

    })

})