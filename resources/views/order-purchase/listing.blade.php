
<?php //dd($data); ?>
<div class="container px-4 px-lg-5 mt-0 item-section" style="{{ count($data) == 0? 'justify-content: center' : ''}}">
    @if (count($data) == 0)
        <img style="max-width: 500px; max-height: 200px; min-width: 300px; min-height: 200px !important; align-self: center;" alt="lazyloaded image" srcset="{{ asset('assets/no-result.png') }}" data-lazyload="{{ asset('assets/empty-cart.png') }}" data-loaded="true">
        <div style="font-weight: bold; font-size: 25px; align-self: center; color: #8c8d94;">No order purchase</div>
    @endif

    <div class="row gx-6 row-cols-6">
        @foreach ($data as $item)
            <div class="po-container">
                <button type="button" class="po-button pomodal" idx="{{ $item['idx'] }}" value="{{ $item['status'] }}" data-target="#pomodal">
                    <span class="content">{{ $item['po_no'] }}</span>
                    <span class="po-badge po-badge-{{ $item['idx'] }} {{($item['status'] == 1? 'po-normal' : ($item['status'] == 2? 'po-success':'po-reject')) }}">
                        @if ($item['status'] == 1)
                            <i class="fas fa-truck po-icon po-normal status-{{ $item['idx'] }}" style="font-size: 13px; position: relative; left: 2px;" id="status-{{ $item['idx'] }}" idx="{{ $item['idx'] }}"></i>
                        @elseif ($item['status'] == 2)
                            <i class="fas fa-check po-icon po-success status-{{ $item['idx'] }}" style="position: relative; top: 1px;" id="status-{{ $item['idx'] }}" idx="{{ $item['idx'] }}"></i>
                        @else
                            <i class="fas fa-times po-icon po-reject status-{{ $item['idx'] }}" style="position: relative; left: 1px;" id="status-{{ $item['idx'] }}" idx="{{ $item['idx'] }}"></i>
                        @endif
                    </span>
                </button>
            </div>

        @endforeach
    </div>
</div>

