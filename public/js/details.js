
    $('.selectpicker').selectpicker('refresh');

    $('.btn-quantity-number').click(function(e) {
        e.preventDefault();
        var fieldName       = $(this).attr('data-field'),
            type            = $(this).attr('data-type'),
            qty_input       = $("input[name='" + fieldName + "']"),
            currentVal      = parseInt(qty_input.val()),
            input           = $("#input-quantity");

        $('.btn-quantity-number[data-type="minus"]').attr('disabled', true);
        $('.btn-quantity-number[data-type="plus"]').attr('disabled', false);

        if (!isNaN(currentVal)) {
            if(type === 'minus') {
                if(parseInt(qty_input.val()) == qty_input.attr('min')) {
                    $(this).attr('disabled', true);
                } else {
                    qty_input.val(currentVal - 1).change();
                    $('.btn-quantity-number[data-type="minus"]').attr('disabled', false);
                    $('.btn-quantity-number[data-type="plus"]').attr('disabled', false);
                }
            } else if(type === 'plus') {
                    if(parseInt(qty_input.val()) == qty_input.attr('max')) {
                        $(this).attr('disabled', true);
                        $('.btn-quantity-number[data-type="minus"]').attr('disabled', false);
                    } else {
                        qty_input.val(currentVal + 1).change();
                        $('.btn-quantity-number[data-type="minus"]').attr('disabled', false);
                        $('.btn-quantity-number[data-type="plus"]').attr('disabled', false);
                    }
            }
        } else {
            qty_input.val(1);
        }
        qty = 0;
    });

    $(".input-quantity-number").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190, 110]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
