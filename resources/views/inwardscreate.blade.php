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
                        htmlSelect('i_party_name', $data),
                        array('name'=>'i_party_name', 'class' => 'form-control chosen-select party_name required', 'placeholder' => '' , setDisable('i_party_name' , $data['disabled'])))
                    }}
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control datepicker required" id="i_date" name = "i_date" placeholder="Enter Date" value = "{{htmlValue('i_date', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control required" id="i_quantity" name = "i_quantity" placeholder="Enter Quantity" value = "{{htmlValue('i_quantity', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Problem</label>
                    <input type="text" class="form-control required" id="i_problem" name = "i_problem" placeholder="Enter Problem" value = "{{htmlValue('i_problem', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control required" id="i_address" name = "i_address" placeholder="Enter Address" >{{htmlValue('i_address', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Product Description</label>
                    <textarea class="form-control required" id="i_product_description" name = "i_product_description" placeholder="Enter Product Description" >{{htmlValue('i_product_description', $data)}}</textarea>
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Contact Number</label>
                    <input type="text" maxlength="10" class="form-control required number" id="i_contact_number" name = "i_contact_number" placeholder="Enter Contact Number" value = "{{htmlValue('i_contact_number', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Remark</label>
                    <input type="text" class="form-control required" id="i_remark" name = "i_remark" placeholder="Enter Remark" value = "{{htmlValue('i_remark', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Accessories</label>
                    <input type="text" class="form-control required" id="i_accessories" name = "i_accessories" placeholder="Enter Accessories" value = "{{htmlValue('i_accessories', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Warranty/Chargable</label>
                    <input type="text" class="form-control required" id="i_warranty" name = "i_warranty" placeholder="Enter Warranty/Chargable" value = "{{htmlValue('i_warranty', $data)}}">
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
                        var address = res.c_address;
                        var telephone = res.c_telephone;

                        $('#i_address').val(address);
                        $('#i_contact_number').val(telephone);
                        console.log(res);
                    }
                })
            });
        });
    </script>

@endsection