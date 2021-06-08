$(document).ready(function() {
    $(document).on('click', '.close-custom__modal, .view-custom__modal', function () {
        $('#custom-modal').slideToggle("medium");
    });

    $('.close').on('click',function(){
        $('#pmodal').modal('hide');
   });

    $('.cart-close').on('click',function(){
        $('#cmodal').modal('hide');
    });

    $(document).off('click','.pmodal').on("click", ".pmodal", function (e) {
        idx = $(this).attr('idx');
        $('#btn-add-cart').attr('idx', '');
        $('#pmodal').modal('show');
        $('.product-data').html("");
        $('.detail-cart').hide();
        $.ajax({
            type: 'GET',
            url:  'requestProductDetail?product_idx=' + idx,
            dataType: 'HTML',
            beforeSend: function () {
                $('#ajax-loader').show();
                $('.product-data').html('');
            },
            success: function (html) {
                $('#ajax-loader').hide();
                $('#btn-add-cart').attr('idx', idx);
                $('.product-data').html(html);
                $('.detail-cart').show();
            },
            error: function (data) {
                $('#ajax-loader').hide();
                swal("Opps", "Something went wrong", "warning");
                $('#pmodal').modal('hide');
            }
        });
    });

    $(document).off('click','.cmodal').on("click", ".cmodal", function (e) {
        $('#cmodal').modal('show');
        $('.cart-data').html("");
        $('.cart-footer-btn').hide();
        $.ajax({
            type: 'GET',
            url:  'getCartItems',
            dataType: 'HTML',
            beforeSend: function () {
                $('#cart-loader').show();
                $('.cart-data').html('');
            },
            success: function (html) {
                $('#cart-loader').hide();
                $('.cart-data').html(html);
                $('.cart-footer-btn').show();
            },
            error: function (data) {
                $('#cart-loader').hide();
                swal("Opps", "Something went wrong", "warning");
                $('#cmodal').modal('hide');
            }
        });
    });

    $(document).on('click', '#btn-checkout-cart', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url:  'checkout',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            beforeSend: function () {
                $('#cart-loader').show();
                $('.cart-data').hide();
            },
            success: function (data) {
                $('.cart-data').show();
                $('#cart-loader').hide();
                if(data.success == true) {
                    if(data.no_checkout) {
                        swal('No action perform', 'Your cart is empty', 'info');
                    } else {
                        swal('Success', 'Item(s) checkout', 'success');
                    }
                    $('#cmodal').modal('hide');
                    if (title == 'Purchase Orders' && data.no_checkout != true) {
                        location.reload();
                    }
                    $('#itemCountBadge').html(data.count);
                } else {
                    swal('Failed', 'Failed to checkout', 'error');
                }
            },
            error: function (data) {
                swal("Opps", "Something went wrong", "warning");
            }
        });
    });

    $(document).on('click', '#btn-add-cart', function(e) {
        e.preventDefault();
        let idx = $(this).attr('idx');
        let qty = $('#input-quantity').val();
        let variations = [];
        let composites = [];
        let variation_details = item.variations;
        let composite_details = item.composite_components;
        if(item.variations.length > 0) {
            item.variations.forEach((variation, i) => {
                let selectedOpt = $('#var_options_'+variation.id).find('option:selected').val();
                variations.push({'id': variation.id, 'val': selectedOpt,});
            });
        }

        if(item.composite_components.length > 0) {
            item.composite_components.forEach((composite, i) => {
                let selectedOpt = $('#comp_options_'+composite.id).find('option:selected').val();
                composites.push({'id': composite.id, 'val': selectedOpt});
            });
        }

        if(qty <= 0) {
            swal("Order minimum quantity", "Minimum order quantity should be 1", "info");
            return;
        }

        var formData = {
            idx,
            qty,
            variations,
            composites,
            variation_details,
            composite_details,
        }

        $.ajax({
            type: 'POST',
            url:  'addToCart',
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            data: formData,
            beforeSend: function () {
                $('#ajax-loader').show();
                $('.product-data').hide();
            },
            success: function (data) {
                $('.product-data').show();
                $('#ajax-loader').hide();
                if(data.success == true) {
                    swal('Success', 'Item(s) added to cart', 'success');
                    $('#pmodal').modal('hide');
                    $('#itemCountBadge').html(data.count);
                } else {
                    swal('Failed', 'Failed to add item to cart', 'error');
                    $('.product-data').show();
                }
            },
            error: function (data) {
                swal("Opps", "Something went wrong", "warning");
                $('#pmodal').modal('hide');
            }
        });
    });
});
