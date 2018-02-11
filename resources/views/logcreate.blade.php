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
@else
@endif
<input type="hidden" name="screen_name" value = "{{(isset($data) && isset($data['screen_name'])) ? $data['screen_name'] : ''}}">
<form id="validateForm" action="#" method="post">

<section class="panel">
    <div class="panel-body">
        <div class = "row">
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Party Name</label>
                    <input type="text" class="form-control required" name="partyname" placeholder="Party Name">
                </div>
                <div class="form-group">
                    <label>Log Date And Time</label>
                    <input type="text" class="form-control datetimepicker required" name="date" placeholder="Log Date And Time">
                </div>
                <div class="form-group">  
                    <label>Contact Number</label>
                    <input type="text" maxlength="10" class="form-control required number" name="phonenumber" placeholder="Contact Number">
                </div>
                <div class="form-group">
                    <label>Called By</label>
                    <input type="text" class="form-control required" name="calledby" placeholder="Called By">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Engineer Assigned</label>
                    <input type="text" class="form-control required" name="engassigned" placeholder="Engineer Assigned">
                </div>
                <div class="form-group">
                    <label>Problem Description</label>
                    <textarea class="form-control required" name="problemdesc" placeholder="Problem Description" ></textarea>
                </div>
                <div class="form-group">
                    <label>Part To Be Taken</label>
                    <input type="text" class="form-control required" name="partbtaken" placeholder="Part To Be Taken">
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.custom_partials.save_panel')
</form>

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
            $('.datetimepicker').datetimepicker();
        });
    </script>

@endsection