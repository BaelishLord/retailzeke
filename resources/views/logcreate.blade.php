@extends('layouts.app')

@section('custom-styles')
  
    @include('layouts.style_loaders.token_loader')
    <link href="{{ asset('/css/common/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
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
            <div class = "col-md-6">
                <div class="form-group">
                    <label for="party_name">Party Name*</label>
                    {{
                        Form::select('party_name',
                        (isset($data) && isset($data['party_name'])) ? $data['party_name'] : [],
                        htmlSelect('l_party_name', $data),
                        array('name'=>'l_party_name', 'class' => 'form-control chosen-select party_name required', 'placeholder' => '' , setDisable('l_party_name' , $data['disabled'])))
                    }}
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Log Date And Time*</label>
                    <input type="text" class="form-control datetimepicker required" id="l_log_date" name = "l_log_date" placeholder="Enter Log Date And Time" value = "{{htmlValue('l_log_date', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-4">
                <div class="form-group">  
                    <label>Contact Number*</label>
                    <input type="text" maxlength="10" class="form-control required number" id="l_contact_number" name = "l_contact_number" placeholder="Enter Contact Number" value = "{{htmlValue('l_contact_number', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" class="form-control required" id="l_email" name = "l_email" placeholder="Enter Email" value = "{{htmlValue('l_email', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Called By*</label>
                    <input type="text" class="form-control required" id="l_called_by" name = "l_called_by" placeholder="Enter Called By" value = "{{htmlValue('l_called_by', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Problem Description*</label>
                    <textarea class="form-control required" id="l_problem_description" name = "l_problem_description" placeholder="Enter Problem Description" >{{htmlValue('l_problem_description', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Engineer Assigned*</label>
                    <input type="text" class="form-control required" id="l_assigned_engineer" name = "l_assigned_engineer" placeholder="Enter Engineer Assigned" value = "{{htmlValue('l_assigned_engineer', $data)}}">
                </div>
            </div>
            <div class = "col-md-4">
                <div class="form-group">
                    <label>Part To Be Taken*</label>
                    <input type="text" class="form-control required" id="l_part_to_be_taken" name = "l_part_to_be_taken" placeholder="Enter Part To Be Taken" value = "{{htmlValue('l_part_to_be_taken', $data)}}">
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
    <script src="{{ asset('/js/common/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            chosenInit();
            $('.datetimepicker').datetimepicker({ 
                format: 'YYYY-MM-DD HH:mm:ss'
            });

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
                        // var address = res.c_address;
                        var telephone = res.c_telephone;
                        var email = res.c_email;

                        // $('#i_address').val(address);
                        $('#l_contact_number').val(telephone);
                        $('#l_email').val(email);
                        console.log(res);
                    }
                })
            });
        });
    </script>

@endsection