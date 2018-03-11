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
    {!! Form::model($data, ['url' => ["/".Request::segment(1)."/".Request::segment(2), $data->getRouteKey()], 'method' => 'put', 'id' => 'validateForm']) !!}
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
                    <input type="text" class="form-control required" id="v_name" name = "v_name" placeholder="Enter Name" value = "{{htmlValue('v_name', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Company/Group Name*</label>
                    <input type="text" class="form-control required" id="v_company_name" name = "v_company_name" placeholder="Enter Company/Group Name" value = "{{htmlValue('v_company_name', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group"> 
                    <label>Address*</label>
                    <textarea class="form-control required" id="v_address" name = "v_address" placeholder="Enter Address">{{htmlValue('v_address', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>GSTN*</label>
                    <input type="text" class="form-control required" id="v_gstn" name = "v_gstn" placeholder="Enter GSTN" value = "{{htmlValue('v_gstn', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" class="form-control required" id="v_email" name = "v_email" placeholder="Enter Email" value = "{{htmlValue('v_email', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Telephone*</label>
                    <input type="text" class="form-control number required" maxlength="10" id="v_telephone" name = "v_telephone" placeholder="Enter Telephone" value = "{{htmlValue('v_telephone', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Alternate Email*</label>
                    <input type="email" class="form-control required" id="v_alternate_email" name = "v_alternate_email" placeholder="Enter Email" value = "{{htmlValue('v_alternate_email', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group"> 
                    <label>Alternate Contact Number*</label>
                    <input type="text" class="form-control required number" id="v_alternate_telephone" name = "v_alternate_telephone" placeholder="Enter Telephone" maxlength="10" value = "{{htmlValue('v_alternate_telephone', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Birthday (Optional)</label>
                    <div class="input-group">
                       <input type="text" class="form-control datepicker" id="v_birthday" name = "v_birthday" placeholder="Enter Birthday (Optional)" value = "{{htmlValue('v_birthday', $data)}}">
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
                       <input type="text" class="form-control datepicker" id="v_annivarsary" name = "v_annivarsary" placeholder="Enter Annivarsary" value = "{{htmlValue('v_annivarsary', $data)}}">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Product Dealing In*</label>
                    <input type="text" class="form-control required" id="v_product_dealin" name = "v_product_dealin" placeholder="Enter Product Dealing In" value = "{{htmlValue('v_product_dealin', $data)}}">
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