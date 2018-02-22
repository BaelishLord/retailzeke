<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ app()->getLocale() }}">

@section('htmlheader')
    @include('layouts.partials.htmlheaderwrap')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-purple layout-boxed">
<div class="wrapper">
    @include('layouts.partials.mainheaderwrap')

    @include('layouts.partials.sidebarwrap')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        
        @include('layouts.partials.contentheaderwrap')

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('layouts.partials.footerwrap')

    @include('layouts.partials.controlsidebarwrap')

</div><!-- ./wrapper -->

@section('scripts')
    @include('layouts.partials.scriptswrap')
    @include('layouts.custom_partials.error_partialwrap')
@show

</body>
</html>