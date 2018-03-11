@extends('layouts.app')

@section('custom-styles')
  
    @include('layouts.style_loaders.token_loader')
    <link href="{{ asset('/css/common/chosen.min.css') }}" rel="stylesheet" type="text/css" />
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
                    <label for="party_name">Party Name*</label>
                    {{
                        Form::select('party_name',
                        (isset($data) && isset($data['party_name'])) ? $data['party_name'] : [],
                        htmlSelect('mnt_party_name', $data),
                        array('name'=>'mnt_party_name', 'class' => 'form-control required chosen-select party_name', 'placeholder' => '' , setDisable('mnt_party_name' , $data['disabled'])))
                    }}
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control required" id="mnt_type" name = "mnt_type">
                        <option value="">--Please Select--</option>
                        <option value="AMC">AMC</option>
                        <option value="Antivirus">Antivirus</option>
                        <option value="Software Renewal">Software Renewal</option>
                        <option value="Warranty Maintainance">Warranty Maintainance</option>
                    </select>
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-4">
                <div class="form-group">
                    <label>From Date</label>
                    <input type="text" class="form-control datepicker required" id="mnt_from_date" name = "mnt_from_date" placeholder="Enter From Date" value = "{{htmlValue('mnt_from_date', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>To Date</label>
                    <input type="text" class="form-control datepicker required" id="mnt_to_date" name = "mnt_to_date" placeholder="Enter To Date" value = "{{htmlValue('mnt_to_date', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Product Serial Number</label>
                    <input type="text" class="form-control required" id="mnt_product_serial_number" name = "mnt_product_serial_number" placeholder="Enter Product Serial Number" value = "{{htmlValue('mnt_product_serial_number', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Rate*</label>
                    <input type="number" class="form-control required number" id="mnt_rate" name = "mnt_rate" placeholder="Enter Rate" value = "{{htmlValue('mnt_rate', $data)}}">
                </div>
            </div>
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control required number" id="mnt_quantity" name = "mnt_quantity" placeholder="Enter Quantity" value = "{{htmlValue('mnt_quantity', $data)}}">
                </div>
            </div>
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Sub Total</label>
                    <input type="number" class="form-control required number" id="mnt_subtotal" name = "mnt_subtotal" placeholder="Enter Sub Total" readonly value = "{{htmlValue('mnt_subtotal', $data)}}">
                </div>
            </div>
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Taxes</label>
                    <input type="number" class="form-control required" id="mnt_taxes" name = "mnt_taxes" placeholder="Enter Taxes" value = "{{htmlValue('mnt_taxes', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" class="form-control required number" id="mnt_total" name = "mnt_total" placeholder="Enter Total" readonly value = "{{htmlValue('mnt_total', $data)}}">
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
    <script src="{{ asset('/js/common/chosen.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            chosenInit();
            $('.datepicker').datepicker({ format: 'yyyy-mm-dd' });

            $(document).on('keyup', '#mnt_rate,#mnt_quantity', function() {
                var quantity = parseInt($('#mnt_quantity').val().trim());
                var rate = parseInt($('#mnt_rate').val().trim());

                if (quantity && rate) {
                    $('#mnt_subtotal').val((quantity*rate));
                } else {
                    $('#mnt_subtotal').val('');
                }
            });

            $(document).on('keyup', '#mnt_taxes', function() {
                var taxes = parseInt($('#mnt_taxes').val().trim());
                var quantity = parseInt($('#mnt_quantity').val().trim());
                var rate = parseInt($('#mnt_rate').val().trim());

                if (quantity && rate && taxes) {
                    $('#mnt_total').val(((quantity*rate) + taxes));
                } else {
                    $('#mnt_total').val('');
                }
            });
        });
    </script>

@endsection