

$(document).ready(function(){
    // $('a.page-link').on('click',function(e){
    //     e.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1];
    //     $.ajax({
    //         url: 'show?page='+page,
    //         type: "GET",
    //         success: function(data){
    //             $('body').html(data);
    //         }
    //     })
    // });
   

    $('a.link-delete').on('click', function(e){
        e.preventDefault();
        var cate_id = $(this).attr('href').split('delete/')[1];
        
        $.get(
            'delete/'+ cate_id,
            function(data){
                location.reload();
            }
        )
    });
    $('a.link-delete-photo').on('click', function(e){
        if(confirm('Bạn có chắc muốn xóa?')){
            var photo_id = $(this).attr('photo_id');
        
            $.get(
            'delete/'+ photo_id,
            function(data){
                location.reload();
            })
        }else{
            e.preventDefault();
        }
        
    });
    $('a.delete-order').on('click', function(e){
        e.preventDefault();
        var order_id = $(this).attr('order_id');
        if(confirm('Bạn có chắc muốn xóa?')){
            $.get(
            'http://thienpham.com/admin/order/delete/',
            {'order_id': order_id},
            function(data){
                location.reload();
               
            })
        }
        
    });
})