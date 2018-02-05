@if (Session::has('message'))
    <div style = "width:100%;position:fixed;z-index: 1001;" class="alert alert-dismissible {{ Session::get('class') }}">{{ Session::get('message') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
    {{ Session::forget('message') }}
    <script type="text/javascript">
        setTimeout(function() {
            $(".alert").fadeTo(3000, 500).slideUp(500);
        }, 3000)
    </script>
@endif