@extends('layouts.app')

@section('custom-styles')
  
    @include('layouts.style_loaders.token_loader')
    <link href="{{ asset('/css/common/datepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/common/common.css') }}" rel="stylesheet" type="text/css" />
    
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
    {!! Form::model($data, ['url' => ["/".Request::segment(1)."/".Request::segment(2), $data->getRouteKey()], 'method' => 'put']) !!}
@else
    {!! Form::open(['url' => "/".Request::segment(1)]) !!}
@endif

<input type="hidden" name="screen_name" value = "{{(isset($data) && isset($data['screen_name'])) ? $data['screen_name'] : ''}}">

<section class="panel">
    <div class="panel-body">
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control required" name="customername" placeholder="Name">
                </div>
                <div class="form-group">
                    <label>Company/Group Name</label>
                    <input type="text" class="form-control required" name="companyname" placeholder="Company/Group Name">
                </div>
                <div class="form-group"> 
                    <label>Address</label>
                    <textarea class="form-control required" placeholder="Address" style=""></textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Telephone</label>
                    <input type="number" class="form-control required" name="phonenumber" placeholder="Telephone">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control required" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>GST/Others</label>
                    <input type="text" class="form-control required" name="gstother" placeholder="GST/Others">
                </div>
                <div class="form-group">
                    <label>Birthday/Annivarsary (Optional)</label>
                    <input type="text" class="form-control datepicker" name="dob" placeholder="Birthday/Annivarsary (Optional)">
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.custom_partials.save_panel')
{!! Form::close() !!}

@endsection

@section('php-to-js')
    <?php
        $js_data = array();
        $js_data['env'] = env('APP_ENV');
    ?>
@endsection

@section('custom-scripts')
    <script src="{{ asset('/js/common/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker();
        });
    </script>

@endsection