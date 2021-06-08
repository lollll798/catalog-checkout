<div class="text-center" id="{{ $item->idx }}">
    <h5 class="fw-bolder">{{ $item->name }}</h5>

    <div class="d-flex justify-content-center small text-warning mb-2">
        <div class="bi-star-fill"></div>
        <div class="bi-star-fill"></div>
        <div class="bi-star-fill"></div>
        <div class="bi-star-fill"></div>
        <div class="bi-star-fill"></div>
    </div>

    @if ($item->min_price != 0.0 && $item->max_price != 0.0)
        <span>{{ $item->currency }}&nbsp;{{ $item->min_price }}</span> - <span>{{ $item->currency }}&nbsp;{{ $item->max_price }}</span>
    @elseif ($item->regular_price != '' && $item->sale_price != '')
        <span class="text-muted text-decoration-line-through">{{ $item->currency }}&nbsp;{{ $item->regular_price }}</span>
        <span>{{ $item->currency }}&nbsp;{{ $item->sale_price }}</span>
    @elseif ($item->regular_price != '')
        <span>{{ $item->currency }}&nbsp;{{ $item->regular_price }}</span>
    @else
        <span>Price depends on option</span>
    @endif
    <br/>
</div>
