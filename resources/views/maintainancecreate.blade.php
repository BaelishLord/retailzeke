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
                    <label>Type</label>
                    <select class="form-control required" id="m_type" name = "m_type">
                        <option value="">--Please Select--</option>
                        <option value="amc">AMC</option>
                        <option value="antivirus">Antivirus</option>
                        <option value="renewal">Software Renewal</option>
                        <option value="warranty">Warranty Maintainance</option>
                    </select>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Party Name</label>
                    <input type="text" class="form-control required" id="m_name" name = "m_name" placeholder="Enter Party Name" value = "{{htmlValue('m_name', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>From Date</label>
                    <input type="text" class="form-control datepicker required" id="m_from_date" name = "m_from_date" placeholder="Enter From Date" value = "{{htmlValue('m_from_date', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>To Date</label>
                    <input type="text" class="form-control datepicker required" id="m_to_date" name = "m_to_date" placeholder="Enter To Date" value = "{{htmlValue('m_to_date', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Product Serial Number</label>
                    <input type="text" class="form-control required" id="m_product_serial_number" name = "m_product_serial_number" placeholder="Enter Product Serial Number" value = "{{htmlValue('m_product_serial_number', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control required number" id="m_quantity" name = "m_quantity" placeholder="Enter Quantity" value = "{{htmlValue('m_quantity', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Sub Total</label>
                    <input type="number" class="form-control required number" id="m_subtotal" name = "m_subtotal" placeholder="Enter Sub Total" value = "{{htmlValue('m_subtotal', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Taxes</label>
                    <input type="text" class="form-control required" id="m_taxes" name = "m_taxes" placeholder="Enter Taxes" value = "{{htmlValue('m_taxes', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" class="form-control required number" id="m_total" name = "m_total" placeholder="Enter Total" value = "{{htmlValue('m_total', $data)}}">
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