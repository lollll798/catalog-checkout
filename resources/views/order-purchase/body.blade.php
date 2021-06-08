<div class="cart-item__label" style="font-weight: bold; margin-left: 15px; font-size: 20px; width: 100%;">
    Order Purchase No: {{ $po['po_no'] }}
</div>
<div class="cart-item__label" style="margin-left: 15px; font-size: 15px; float: left; width: 100%;">
    Status: {{ ($po['status'] == 1? 'Shipping' : ($po['status'] == 2? 'Completed' : 'Rejected')) }}
    &emsp;
    @if (empty($po['updated_at']))
        Checkout at: {{ $po['checkout_date'] }}
    @else
        {{$po['status'] == 2? 'Received' : 'Rejected'}} at: {{ $po['checkout_date'] }}
    @endif
</div>
<br/><hr/>

@if (count($poItems) == 0)
<img style="max-width: 500px; max-height: 200px; min-width: 300px; min-height: 200px !important;" alt="lazyloaded image" srcset="{{ asset('assets/empty-cart.png') }}" data-lazyload="{{ asset('assets/empty-cart.png') }}" data-loaded="true">
<div style="font-weight: bold; font-size: 25px; position: relative; right: 40px;">No items inside cart</div>
@endif

@foreach ($poItems as $item)
<div class="cart-item__content" style="margin-bottom: 20px">
<div class="cart-item__title" style="display: inline-flex; width: 100%;">
    <div class="col-md-2 cart-item__thumbnail">
        <div class="js--lazyload">
            <img style="max-width: 100px; max-height: 100px; min-width: 100px; min-height: 100px !important;" class="card-img-top" alt="lazyloaded image" srcset="{{ $item['images'][0]->src }}" data-lazyload="{{ $item['images'][0]->src }}" data-loaded="true">
        </div>
    </div>
    <div class="col-md-8 cart-item__main--info" style="margin-left: 15px; text-align-last: left;">
        <div class="cart-item__label" style="font-weight: bold; margin-top: 10px;">
            {{ $item['name'] }}
            @if ($item['sku'] != '')
                ({{ $item['sku'] }})
            @endif
        </div>

        @foreach ($item['components'] as $comp)
            <div style="width: 100%; display: inline-flex; margin-top: 5px;">
                <div class="col-md-4" style="align-self: center;">
                    {{ $comp['title'] }}
                </div>
                <div class="col-md-6">
                    {{ $comp['name'] }}
                </div>
            </div>
        @endforeach

        @foreach ($item['variations'] as $variation)
            <div style="width: 100%; display: inline-flex; margin-top: 5px;">
                <div class="col-md-4" style="align-self: center;">
                    {{ $variation['variation_name'] }}
                </div>
                <div class="col-md-6">
                    {{ $variation['selected_unit'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>
@endforeach
