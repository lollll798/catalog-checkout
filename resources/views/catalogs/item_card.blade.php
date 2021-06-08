@if ($item->catalog_visibility == 'visible')
    <div class="col mb-5" id="{{ $item->id }}">
        <div class="card h-100">
            <div class="position-absolute" style="top: 0.5rem; right: 0.5rem">
                @include('partials.badges')
            </div>

            @include('partials.images')
            <div class="card-body p-4">
                @include('partials.item_details')
            </div>

            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <button type="button" class="text-center pmodal btn btn-view-options btn-outline-dark mt-auto" data-toggle="modal" idx="{{ $item->idx }}" data-target="#pmodal">
                    View Option
                </button>
            </div>
        </div>
    </div>
@endif
