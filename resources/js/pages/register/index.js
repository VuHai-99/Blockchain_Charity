function uploadImage(image, fileInputId) {
    $(`#${fileInputId}`).change(function(e) {
        //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            //Sự kiện file đã được load vào website
            reader.onload = function(e) {
                //Thay đổi đường dẫn ảnh
                $(`#${image}`).attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    })
}
$(function() {
    if ($('#host').prop('checked') == true) {
        $('.upload-file').show();
    }
    $('#donator').change(function() {
        if ($(this).prop("checked") == true) {
            $('.upload-file').hide();
        }
    });
    $('#host').change(function() {
        if ($(this).prop("checked") == true) {
            $('.upload-file').show();
        }
    });
    $('#card1').on('click', function() {
        $('#img1').click();
    })
    $('#card2').on('click', function() {
        $('#img2').click();
    })
    uploadImage('card1', 'img1');
    uploadImage('card2', 'img2');
})
