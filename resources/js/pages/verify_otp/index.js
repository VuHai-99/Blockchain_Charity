$(function() {
    //console.log(laroute.route('login'));
    var error = 0;
    $('.btn-confirm').click(function(e) {
        var otp = $(`input[name='otp']`).val();
        axios.post(laroute.route('api.verify.otp'), {
                'otp': otp,
            })
            .then(function(response) {
                if (response.data.status === 1) {
                    error += 1;
                    $('.notify').html('Mã không chính xác. Xin nhập lại.');
                    if (error == 3) {
                        showPopupOk('', 'Bạn đã nhập sai mã OTP quá 3 lần, vui lòng quay lại trang đăng nhập', 'OK', function() {

                        })
                    }
                    if (error > 3) {
                        window.location.replace(laroute.route('redirect.error'));
                    }
                } else {
                    $('#form-verify-otp').submit();
                }
            })

    })
})
