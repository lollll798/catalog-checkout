
<div class="container px-4 px-lg-5 mt-0 item-section">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
        @foreach ($data['catalogLists'] as $item)
            @include('catalogs.item_card')
        @endforeach
    </div>
    <div id="footer" class="col-12 catalog-paginate">
        @include('catalogs.pages')
    </div>
</div>
