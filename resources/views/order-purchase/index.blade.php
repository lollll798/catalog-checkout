<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ $title }}</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky">
            @include('top-nav')
        </nav>

        <section class="py-5 content">
            @include('order-purchase.listing')
            @include('order-purchase.model')
            @include('carts.model')
            @include('notification.model')
        </section>

        <footer class="py-5 bg-dark main-footer">
            @include('footer')
        </footer>
    </body>
</html>


<link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/catalog.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/notification.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('css/order-purchase.css') }}" rel="stylesheet" type="text/css" >

<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var title = <?php echo(json_encode($title)) ?>;
</script>
<script type="text/javascript" src="{{ asset('js/catalog.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/notification.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/order-purchase.js') }}"></script>
