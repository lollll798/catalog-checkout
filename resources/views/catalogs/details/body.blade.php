<?php
    $item = $data;
?>
<div class="col-md-12" style="display: flex; flex-wrap: wrap">
    <div class="col-md-3" style="margin:0 auto;align-content: center;display: flex;">
        @include('partials.images')
    </div>
    <div class="col-md-8" style="margin-top: 1rem;">
        <div class="row">
            <div class="col-md-12">
                <span class="item-name" style="font-weight: bold;">{{ $item->name }}
                    @if ($item->sku != '')
                        ({{ $item->sku }})
                    @endif
                </span>
                <br/>
                <span>Type: {{ $item->type }}</span>
                <br/>
                <div class="badge-inner" style="margin-top: 3px; margin-bottom: 10px;">
                    @include('partials.badges')
                </div>
            </div>

            <div class="col-md-12 item-variation">
                @foreach ($item->variations as $varKey => $variation)
                    <div varid='{{ $variation->id }}' style="width: 100%; display: inline-flex; margin-bottom: 10px;">
                        <div class="col-md-4" style="align-self: center;">
                            {{ $variation->name }}
                        </div>
                        <div class="col-md-8">
                            <select idx='{{ $variation->id }}' class="form-control input-var var_options selectpicker" id="var_options_{{ $variation->id }}" style="height: 2rem !important">
                                @foreach ($variation->options as $option)
                                    <option class="dropdown-item" value="{{ $option->val }}" idx="{{ $item->idx }}" {{ ($option->default == 1)? "selected": "" }}>{{ $option->val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12 item-composite">
                @foreach ($item->composite_components as $compKey => $composite)
                    <div compid='{{ $composite->id }}' style="width: 100%; display: inline-flex; margin-bottom: 10px;">
                        <div class="col-md-4" style="align-self: center;">
                            {{ $composite->title }}
                        </div>
                        <div class="col-md-8">
                            <select idx='{{ $composite->id }}' class="form-control input-comp comp_options selectpicker" id="comp_options_{{ $composite->id }}" style="height: 2rem !important">
                                @foreach ($composite->options as $keyOpt => $option)
                                    <option class="dropdown-item comp{{$composite->id}}_opt" value="{{ $option->product_id }}" idx="{{ $item->idx }}" {{ ($keyOpt == 0)? "selected": "" }} varcount="{{ count($option->details->variations) }}" >{{ $option->details->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <div class="plus-minus__wrapper" style="margin-bottom: 5px; margin-top: 10px">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-quantity-number" disabled="disabled" data-type="minus" data-field="qty">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </span>
                                <input type="text" id="input-quantity" name="qty" class="form-control input-quantity-number text-center" value="1" min="1" step="any">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-quantity-number" data-type="plus" data-field="qty">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-5" style="place-self: center; text-align-last: end;">
                            @if ($item->regular_price != '' && $item->sale_price != '')
                                <span class="text-muted text-decoration-line-through" style="font-weight: normal; font-size: 15px;">
                                    {{ $item->currency }}{{ number_format($item->regular_price, 2) }}
                                </span>
                                &nbsp;
                                <span style="font-weight: bold; font-size: 20px;">
                                    {{ $item->currency }}
                                    {{ number_format($item->sale_price, 2) }}
                                </span>
                            @elseif (count($item->variations) != 0 || count($item->composite_components) != 0)
                                {{-- <span style="font-weight: bold; font-size: 20px;">
                                    {{ $item->currency }}XXX.xx
                                </span> --}}
                            @else
                                <span style="font-weight: bold; font-size: 20px;">
                                    {{ $item->currency }}{{ number_format($item->regular_price, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var item = <?php echo(json_encode($item)) ?>;
</script>
<script type="text/javascript" src="{{ asset('js/details.js') }}"></script>
<link href="{{ asset('css/details.css') }}" rel="stylesheet" type="text/css" >

