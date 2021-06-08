@if ($item->sale_price != "")
<div class="badge bg-success text-white" style="top: 0.5rem; right: 0.5rem">
    Sale
</div>
@endif

@foreach ($item->tags as $tags)
<div class="badge bg-info text-white" style="top: 0.5rem; right: 0.5rem">
    {{ $tags->name }}
</div>
@endforeach

@foreach ($item->categories as $category)
    <div class="badge bg-dark text-white" style="top: 0.5rem; right: 0.5rem">
        {{ $category->name }}
    </div>
@endforeach
