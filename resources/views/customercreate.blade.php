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

@if (Request::segment(3))
    {!! Form::model($data, ['url' => ["/".Request::segment(1), $data->getRouteKey()], 'method' => 'put', 'id' => 'validateForm']) !!}
@else
    {!! Form::open(['url' => "/".Request::segment(1), 'id' => 'validateForm']) !!}
@endif

<input type="hidden" name="screen_name" value = "{{(isset($data) && isset($data['screen_name'])) ? $data['screen_name'] : ''}}">

<section class="panel">
    <div class="panel-body">
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" class="form-control required" id="c_name" name = "c_name" placeholder="Enter Name" value = "{{htmlValue('c_name', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Company/Group Name*</label>
                    <input type="text" class="form-control required" id="c_company_name" name = "c_company_name" placeholder="Enter Company Name" value = "{{htmlValue('c_company_name', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group"> 
                    <label>Address*</label>
                    <textarea class="form-control required" id="c_address" name = "c_address" placeholder="Address" style="">{{htmlValue('c_address', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>GSTN*</label>
                    <input type="text" class="form-control required" id="c_gstn" name = "c_gstn" placeholder="Enter GSTN" value = "{{htmlValue('c_gstn', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" class="form-control required" id="c_email" name = "c_email" placeholder="Enter Email" value = "{{htmlValue('c_email', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Telephone*</label>
                    <input type="text" class="form-control required number" id="c_telephone" name = "c_telephone" placeholder="Enter Telephone" maxlength="10" value = "{{htmlValue('c_telephone', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Alternate Email*</label>
                    <input type="email" class="form-control required" id="c_alternate_email" name = "c_alternate_email" placeholder="Enter Email" value = "{{htmlValue('c_alternate_email', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group"> 
                    <label>Alternate Contact Number*</label>
                    <input type="text" class="form-control required number" id="c_alternate_telephone" name = "c_alternate_telephone" placeholder="Enter Telephone" maxlength="10" value = "{{htmlValue('c_alternate_telephone', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Birthday (Optional)</label>
                    <div class="input-group">
                       <input type="text" class="form-control datepicker" id="c_birthday" name = "c_birthday" placeholder="Enter birthday" value = "{{htmlValue('c_birthday', $data)}}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span> 
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Annivarsary (Optional)</label>
                    <div class="input-group">
                       <input type="text" class="form-control datepicker" id="c_annivarsary" name = "c_annivarsary" placeholder="Enter Annivarsary" value = "{{htmlValue('c_annivarsary', $data)}}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span> 
                        </div>
                    </div>
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
            $('.datepicker').datepicker({ format: 'yyyy-mm-dd' });
        });
    </script>

@endsection