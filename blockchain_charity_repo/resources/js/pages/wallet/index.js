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
            $(`input[name='public_key']`).removeAttr('readonly');
            $('.fa-eye-slash').hide();
            $('.fa-eye').show();
            check = true;
        }

    })
    $('#form-change-key').submit(function(e) {
        e.preventDefault();
        if (!check) {
            $('.fa-eye-slash').click();
        } else {
            var privateKey = $(`input[name='private_key']`).val();
            var publicKey = $(`input[name='public_key']`).val();
            axios.post(laroute.route('api.change.key', {
                    'private_key': privateKey,
                    'public_key': publicKey
                }))
                .then(function(response) {
                    toastr.success(response.data.message);
                })
        }
    })
})