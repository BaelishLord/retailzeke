@extends('layouts.app')

@section('custom-styles')
  
    @include('layouts.style_loaders.token_loader')
    <link href="{{ asset('/css/common/datepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/common/chosen.min.css') }}" rel="stylesheet" type="text/css" />
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
            <div class = "col-md-4">
                <div class="form-group">
                    <label for="party_name">Party Name*</label>
                    {{
                        Form::select('party_name',
                        (isset($data) && isset($data['party_name'])) ? $data['party_name'] : [],
                        htmlSelect('q_party_name', $data),
                        array('party_name'=>'q_party_name', 'class' => 'form-control chosen-select party_name required', 'placeholder' => '' , setDisable('q_party_name' , $data['disabled'])))
                    }}
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Date*</label>
                    <div class="input-group">
                       <input type="text" class="form-control datepicker required" id="q_quotation_date" name = "q_quotation_date" placeholder="Enter Date" value = "{{htmlValue('q_quotation_date', $data)}}">
                       <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span> 
                       </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Reference*</label>
                    <input type="text" class="form-control required" id="q_reference" name = "q_reference" placeholder="Enter Order By/Reference" value = "{{htmlValue('q_reference', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Address*</label>
                    <textarea class="form-control required" id="q_address" name = "q_address" placeholder="Enter Address" >{{htmlValue('q_address', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Product Description*</label>
                    <textarea class="form-control required" id="q_product_description" name = "q_product_description" placeholder="Enter Product Description" >{{htmlValue('q_product_description', $data)}}</textarea>
                </div>
            </div>
            
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Contact Number*</label>
                    <input type="text" maxlength="10" class="form-control required" id="q_contact_number" name = "q_contact_number" placeholder="Enter Contact Number" value = "{{htmlValue('q_contact_number', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" class="form-control required" id="q_email" name = "q_email" placeholder="Enter Email" value = "{{htmlValue('q_email', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Quantity*</label>
                    <input type="number" class="form-control required number" id="q_quantity" name = "q_quantity" placeholder="Enter Quantity" value = "{{htmlValue('q_quantity', $data)}}">
                </div>
            </div>
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Rate*</label>
                    <input type="number" class="form-control required number" id="q_rate" name = "q_rate" placeholder="Enter Rate" value = "{{htmlValue('q_rate', $data)}}">
                </div>
            </div>
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Sub Total*</label>
                    <input type="number" class="form-control required number" id="q_subtotal" name = "q_subtotal" placeholder="Enter Sub Total" readonly value = "{{htmlValue('q_subtotal', $data)}}">
                </div>
            </div>
            <div class = "col-md-2">
                <div class="form-group">
                    <label>Taxes*</label>
                    <input type="number" class="form-control required number" id="q_taxes" name = "q_taxes" placeholder="Enter Taxes" value = "{{htmlValue('q_taxes', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Total*</label>
                    <input type="number" class="form-control required number" id="q_total" name = "q_total" placeholder="Enter Total" readonly value = "{{htmlValue('q_total', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Warranty Product*</label>
                    <input type="text" class="form-control required" id="q_warranty_product" name = "q_warranty_product" placeholder="Enter Warranty Product" value = "{{htmlValue('q_warranty_product', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Warranty Chargable*</label>
                    <input type="number" class="form-control required number" id="q_warranty_chargable" name = "q_warranty_chargable" placeholder="Enter Warranty Chargable" value = "{{htmlValue('q_warranty_chargable', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Warranty Date*</label>
                    <div class="input-group">
                       <input type="text" class="form-control datepicker required" id="q_warranty_date" name = "q_warranty_date" placeholder="Enter Warranty Date" value = "{{htmlValue('q_warranty_date', $data)}}">
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
    <script src="{{ asset('/js/common/chosen.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            chosenInit();
            $('.datepicker').datepicker({ format: 'yyyy-mm-dd' });

            $(document).on('change', '.name', function() {
                var id = $(this).val();
                console.log(id)
                $.ajax({
                    url:window.location.href+"/get-customer-data",
                    type:'GET',
                    data: {
                        id : id,
                    },
                    success: function(res) {
                        var address = res.c_address;
                        var telephone = res.c_telephone;
                        var email = res.c_email;

                        $('#q_address').val(address);
                        $('#q_contact_number').val(telephone);
                        $('#q_email').val(email);
                        console.log(res);
                    }
                })
            });

            $(document).on('keyup', '#q_rate,#q_quantity', function() {
                var quantity = parseInt($('#q_quantity').val().trim());
                var rate = parseInt($('#q_rate').val().trim());

                if (quantity && rate) {
                    $('#q_subtotal').val((quantity*rate));
                } else {
                    $('#q_subtotal').val('');
                }
            });

            $(document).on('keyup', '#q_taxes', function() {
                var taxes = parseInt($('#q_taxes').val().trim());
                var quantity = parseInt($('#q_quantity').val().trim());
                var rate = parseInt($('#q_rate').val().trim());

                if (quantity && rate && taxes) {
                    $('#q_total').val(((quantity*rate) + taxes));
                } else {
                    $('#q_total').val('');
                }
            });
        });
    </script>

@endsection