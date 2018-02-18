@extends('layouts.app')

@section('custom-styles')
  
    @include('layouts.style_loaders.token_loader')
    <link href="{{ asset('/css/common/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
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
                    <input type="text" class="form-control required" id="l_party_name" name = "l_party_name" placeholder="Enter Party Name" value = "{{htmlValue('l_party_name', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Log Date And Time</label>
                    <input type="text" class="form-control datetimepicker required" id="l_log_date" name = "l_log_date" placeholder="Enter Log Date And Time" value = "{{htmlValue('l_log_date', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">  
                    <label>Contact Number</label>
                    <input type="text" maxlength="10" class="form-control required number" id="l_contact_number" name = "l_contact_number" placeholder="Enter Contact Number" value = "{{htmlValue('l_contact_number', $data)}}">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Called By</label>
                    <input type="text" class="form-control required" id="l_called_by" name = "l_called_by" placeholder="Enter Called By" value = "{{htmlValue('l_called_by', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Problem Description</label>
                    <textarea class="form-control required" id="l_problem_description" name = "l_problem_description" placeholder="Enter Problem Description" >{{htmlValue('l_problem_description', $data)}}</textarea>
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Engineer Assigned</label>
                    <input type="text" class="form-control required" id="l_assigned_engineer" name = "l_assigned_engineer" placeholder="Enter Engineer Assigned" value = "{{htmlValue('l_assigned_engineer', $data)}}">
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Part To Be Taken</label>
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
    <script src="{{ asset('/js/common/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datetimepicker').datetimepicker({ 
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });
    </script>

@endsection