@extends('layouts.app')

@section('custom-styles')
  
    @include('layouts.style_loaders.token_loader')
    <!-- <link href="{{ asset('/css/common/chosen.min.css') }}" rel="stylesheet" type="text/css" /> -->
    
@endsection

@section('htmlheader_title')
    @include('layouts.custom_partials.htmlheader_title', ['title' => (isset($data) && isset($data['name']) ? $data['name'] : '')])
@endsection


@section('contentheader_title')
    
    @include('layouts.custom_partials.contentheader_title', ['title' => (isset($data) && isset($data['name']) ? $data['name'] : '')])

@endsection

@section('custom-breadcrumb')
    @include('layouts.custom_partials.breadcrumb')
@endsection

@section('contentheader_description')
@endsection

@section('main-content')

@if (Request::segment(4))
@else
@endif
<input type="hidden" name="screen_name" value = "{{(isset($data) && isset($data['screen_name'])) ? $data['screen_name'] : ''}}">

<section class="panel">
    <div class="panel-body">
        <div class = "row">
            <div class = "col-md-3">
                <div class="form-group">
                    <label for="name">Employee *</label>

                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                 <label class="">Role *</label>

                    <input type="hidden" name="deselected_roles" class = "deselected_roles">
                </div>
            </div>
            <div class = "col-md-3 hide">
                <div class="form-group">
                    <label for="event_heads">Status</label>

                </div>
            </div>
        </div>
    </div>
    
</section>

@include('layouts.custom_partials.save_panel')
@endsection

@section('php-to-js')
    <?php
        $js_data = array();
        $js_data['env'] = env('APP_ENV');
    ?>
@endsection

@section('custom-scripts')
    
    <script src="{{ asset('/js/common/chosen.jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {


    });

    </script>

@endsection