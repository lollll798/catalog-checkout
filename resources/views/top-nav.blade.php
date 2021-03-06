<div class="container px-4 px-lg-5">
    <a class="navbar-brand" href="#!">Demo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
            <li class="nav-item"><a class="nav-link {{ $title == 'Catalogs'? 'active' : '' }}" aria-current="page" href="{{ env('HOMESTEAD_URL').'requestCatelogList?page=1' }}">Catalogs</a></li>
            <li class="nav-item"><a class="nav-link {{ $title == 'Purchase Orders'? 'active' : '' }}" href="{{ env('HOMESTEAD_URL').'getOrderPurcahse' }}">Purchase Orders</a></li>
            <input type="hidden" class="top-title" id="top-title" value="{{ $title }}" />
        </ul>
        <button class="btn nmodal" type="button" style="margin-right: 10px">
            <i style="color: #f8f9fa" class="fas fa-bell"></i>
            <span class="badge bg-light text-dark ms-1 rounded-pill" id="notiCountBadge" style="background-color: #ff0000 !important; color: white !important;">
                {{ $notificationCount }}
            </span>
        </button>
        <form class="d-flex">
            <button class="btn btn-outline-light cmodal" type="button">
                <i class="bi-cart-fill me-1"></i>
                Cart
                <span class="badge bg-light text-dark ms-1 rounded-pill" id="itemCountBadge">{{ $cartCount }}</span>
            </button>
        </form>
    </div>
</div>
