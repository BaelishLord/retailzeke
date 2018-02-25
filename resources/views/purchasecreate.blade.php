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
                    <label for="party_name">Party Name</label>
                    {{
                        Form::select('party_name',
                        (isset($data) && isset($data['party_name'])) ? $data['party_name'] : [],
                        htmlSelect('p_party_name', $data),
                        array('name'=>'p_party_name', 'class' => 'form-control required chosen-select party_name', 'placeholder' => '' , setDisable('p_party_name' , $data['disabled'])))
                    }}
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control datepicker required" id="p_purchase_date" name = "p_purchase_date" placeholder="Enter Date" value = "{{htmlValue('p_purchase_date', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control required" id="p_address" name = "p_address" placeholder="Enter Address" >{{htmlValue('p_address', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Product Description</label>
                    <textarea class="form-control required" id="p_product_description" name = "p_product_description" placeholder="Enter Product Description" >{{htmlValue('p_product_description', $data)}}</textarea>
                </div>
            </div>
            
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Reference</label>
                    <input type="text" class="form-control required" id="p_reference" name = "p_reference" placeholder="Enter Order By/Reference" value = "{{htmlValue('p_reference', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control required number" id="p_quantity" name = "p_quantity" placeholder="Enter Quantity" value = "{{htmlValue('p_quantity', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Rate</label>
                    <input type="text" class="form-control required" id="p_rate" name = "p_rate" placeholder="Enter Rate" value = "{{htmlValue('p_rate', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Sub Total</label>
                    <input type="number" class="form-control required number" id="p_subtotal" name = "p_subtotal" placeholder="Enter Sub Total" value = "{{htmlValue('p_subtotal', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Taxes</label>
                    <input type="text" class="form-control required" id="p_taxes" name = "p_taxes" placeholder="Enter Taxes" value = "{{htmlValue('p_taxes', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Contact Number</label>
                    <input type="text" maxlength="10" class="form-control required" id="p_contact_number" name = "p_contact_number" placeholder="Enter Contact Number" value = "{{htmlValue('p_contact_number', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" class="form-control required number" id="p_total" name = "p_total" placeholder="Enter Total" value = "{{htmlValue('p_total', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Warranty</label>
                    <input type="text" class="form-control required" id="p_warranty" name = "p_warranty" placeholder="Enter Warranty" value = "{{htmlValue('p_warranty', $data)}}">
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

            $(document).on('change', '.party_name', function() {
                var id = $(this).val();
                console.log(id)
                $.ajax({
                    url:window.location.href+"/get-customer-data",
                    type:'GET',
                    data: {
                        id : id,
                    },
                    success: function(res) {
                        var address = res.v_address;
                        var telephone = res.v_telephone;

                        $('#p_address').val(address);
                        $('#p_contact_number').val(telephone);
                        console.log(res);
                    }
                })
            });
        });
    </script>

@endsection