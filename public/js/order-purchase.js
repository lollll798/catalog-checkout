$(document).ready(function() {
    $(document).off('click','.pomodal').on("click", ".pomodal", function (e) {
        idx = $(this).attr('idx');
        status = $(this).val();
        $('#btn-po-cancel').attr('idx', '');
        $('#btn-po-receive').attr('idx', '');
        $('#pomodal').modal('show');
        $('.po-data').html("");
        $('.po-footer-btn').hide();
        $.ajax({
            type: 'GET',
            url:  'getOrderPurcahseDetails?idx=' + idx,
            dataType: 'HTML',
            beforeSend: function () {
                $('#po-loader').show();
                $('.po-data').html('');
            },
            success: function (html) {
                $('#po-loader').hide();
                $('#btn-po-cancel').attr('idx', idx);
                $('#btn-po-receive').attr('idx', idx);
                $('.po-data').html(html);
                if (status > 1) {
                    $('.po-footer-btn').hide();
                } else {
                    $('.po-footer-btn').show();
                }
            },
            error: function (data) {
                $('#po-loader').hide();
                swal("Opps", "Something went wrong", "warning");
                $('#pomodal').modal('hide');
            }
        });
    });

    $('.po-close').on('click',function(){
        $('#pomodal').modal('hide');
    });

    $(document).on('click', '#btn-po-cancel', function(e) {
        e.preventDefault();
        idx = $(this).attr('idx');
        status = 3;
        var formData = {
            idx,
            status
        }
        $.ajax({
            type: 'POST',
            url:  'cancelOrder',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            data: formData,
            beforeSend: function () {
                $('#po-loader').show();
                $('.po-data').hide();
            },
            success: function (data) {
                $('.po-data').show();
                $('#po-loader').hide();
                if(data.success == true) {
                    swal('Success', 'Cancel order success', 'success');
                    $('#pomodal').modal('hide');
                    $("i").remove('#status-'+idx);
                    $(".po-badge-"+idx+"").append(assignTag(status, idx));
                    $(".po-badge-"+idx+"").removeClass('po-normal');
                    $(".po-badge-"+idx+"").removeClass('po-success');
                    $(".po-badge-"+idx+"").addClass('po-reject');
                } else {
                    swal('Failed', 'Failed to cancel order purchase', 'error');
                }
            },
            error: function (data) {
                swal("Opps", "Something went wrong", "warning");
            }
        });
    });

    $(document).on('click', '#btn-po-receive', function(e) {
        e.preventDefault();
        idx = $(this).attr('idx');
        status = 2;
        var formData = {
            idx,
            status
        }
        $.ajax({
            type: 'POST',
            url:  'cancelOrder',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            data: formData,
            beforeSend: function () {
                $('#po-loader').show();
                $('.po-data').hide();
            },
            success: function (data) {
                $('.po-data').show();
                $('#po-loader').hide();
                if(data.success == true) {
                    swal('Success', 'Receive order success', 'success');
                    $('#pomodal').modal('hide');
                    $("i").remove('#status-'+idx);
                    $(".po-badge-"+idx+"").append(assignTag(status, idx));
                    $(".po-badge-"+idx+"").removeClass('po-normal');
                    $(".po-badge-"+idx+"").removeClass('po-reject');
                    $(".po-badge-"+idx+"").addClass('po-success');
                } else {
                    swal('Failed', 'Failed to complete order purchase', 'error');
                }
            },
            error: function (data) {
                swal("Opps", "Something went wrong", "warning");
            }
        });
    });

    function assignTag(status, idx) {
        if (status == 1) {
            return '<i class="fas fa-truck po-icon po-normal status-'+idx+'" style="font-size: 13px; position: relative; left: 2px; id="status-'+idx+'" idx="status-'+idx+'"></i>';
        } else if (status == 2) {
            return '<i class="fas fa-check po-icon po-success status-'+idx+'" style="position: relative; left: 1px; id="status-'+idx+'"  idx="status-'+idx+'"></i>';
        } else {
            return '<i class="fas fa-times po-icon po-reject status-'+idx+'" style="position: relative; left: 1px; id="status-'+idx+'"  idx="status-'+idx+'"></i>';
        }
    }
});
