$(document).ready(function() {
    $('.noti-close').on('click',function(){
        $('#nmodal').modal('hide');
    });

    $(document).off('click','.nmodal').on("click", ".nmodal", function (e) {
        idx = $(this).attr('idx');
        status = $(this).val();
        $('#nmodal').modal('show');
        $('.noti-data').html("");
        $.ajax({
            type: 'GET',
            url:  'getNotification',
            dataType: 'HTML',
            beforeSend: function () {
                $('#noti-loader').show();
                $('.noti-data').html('');
            },
            success: function (html) {
                $('#noti-loader').hide();
                $('.noti-data').html(html);
                $('#notiCountBadge').html(0);
            },
            error: function (data) {
                $('#noti-loader').hide();
                swal("Opps", "Something went wrong", "warning");
                $('#nmodal').modal('hide');
            }
        });
    });

    $('.noti-close').on('click',function(){
        $('#nmodal').modal('hide');
    });
});
