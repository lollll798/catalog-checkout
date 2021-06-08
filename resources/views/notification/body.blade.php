@if (count($notifications) == 0)
    <img style="max-width: 500px; max-height: 300px; min-width: 300px; min-height: 200px !important; align-self: center;" alt="lazyloaded image" srcset="{{ asset('assets/no-result.png') }}" data-lazyload="{{ asset('assets/empty-cart.png') }}" data-loaded="true">
    <div style="font-weight: bold; font-size: 25px; align-self: center; color: #8c8d94;">Notification is empty</div>
@endif

@foreach ($notifications as $item)
    <div class="cart-item__content" style="margin-bottom: 20px">
        <div class="cart-item__title" style="display: inline-flex; width: 100%;">
            <div class="col-md-9 cart-item__main--info" style="margin-left: 15px; text-align-last: left;">
                <div class="cart-item__label" style="font-weight: bold; margin-top: 10px;">
                    {{ $item['data']['message'] }}
                </div>
                <div>
                    {{ $item['formated_datetime'] }}
                </div>
            </div>
            <div class="col-md-2 cart-item__main--info" style="margin-left: 15px; text-align-last: left; align-self: flex-end; text-align-last: end;">
                <button class="btn btn-outline-dark pomodal" type="button" idx="{{ $item['data']['idx'] }}" data-target="#pomodal" value="3">
                    <i class="far fa-file-alt"></i>
                    View
                </button>
            </div>
        </div>
    </div>
    <hr/>
@endforeach

