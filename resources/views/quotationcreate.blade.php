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
                    <label>Party Name</label>
                    <input type="text" class="form-control required" id="q_name" name = "q_name" placeholder="Enter Party Name" value = "{{htmlValue('q_name', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control datepicker required" id="q_quotation_date" name = "q_quotation_date" placeholder="Enter Date" value = "{{htmlValue('q_quotation_date', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control required" id="q_address" name = "q_address" placeholder="Enter Address" >{{htmlValue('q_address', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Product Description</label>
                    <textarea class="form-control required" id="q_product_description" name = "q_product_description" placeholder="Enter Product Description" >{{htmlValue('q_product_description', $data)}}</textarea>
                </div>
            </div>
            
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Reference</label>
                    <input type="text" class="form-control required" id="q_reference" name = "q_reference" placeholder="Enter Order By/Reference" value = "{{htmlValue('q_reference', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control required number" id="q_quantity" name = "q_quantity" placeholder="Enter Quantity" value = "{{htmlValue('q_quantity', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Rate</label>
                    <input type="text" class="form-control required" id="q_rate" name = "q_rate" placeholder="Enter Rate" value = "{{htmlValue('q_rate', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Sub Total</label>
                    <input type="number" class="form-control required number" id="q_subtotal" name = "q_subtotal" placeholder="Enter Sub Total" value = "{{htmlValue('q_subtotal', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Taxes</label>
                    <input type="text" class="form-control required" id="q_taxes" name = "q_taxes" placeholder="Enter Taxes" value = "{{htmlValue('q_taxes', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Contact Number</label>
                    <input type="text" maxlength="10" class="form-control required" id="q_contact_number" name = "q_contact_number" placeholder="Enter Contact Number" value = "{{htmlValue('q_contact_number', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" class="form-control required number" id="q_total" name = "q_total" placeholder="Enter Total" value = "{{htmlValue('q_total', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Warranty</label>
                    <input type="text" class="form-control required" id="q_warranty" name = "q_warranty" placeholder="Enter Warranty" value = "{{htmlValue('q_warranty', $data)}}">
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