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
                    <label>Date</label>
                    <input type="text" class="form-control datepicker required" name="dob" placeholder="Date">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control required" name="address" placeholder="Address" ></textarea>
                </div>
                <div class="form-group">  
                    <label>Contact Number</label>
                    <input type="text" maxlength="10" class="form-control required number" name="phonenumber" placeholder="Contact Number">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control required" name="quantity" placeholder="Quantity">
                </div>
            </div>
            <div class = "col-md-6">
                <div class="form-group">
                    <label>Problem</label>
                    <input type="text" class="form-control required" name="problem" placeholder="Problem">
                </div>
                <div class="form-group">
                    <label>Remark</label>
                    <input type="text" class="form-control required" name="remark" placeholder="Remark">
                </div>
                <div class="form-group">
                    <label>Product Description</label>
                    <textarea class="form-control required" name="productdesc" placeholder="Product Description" ></textarea>
                </div>
                <div class="form-group">
                    <label>Accessoies</label>
                    <input type="text" class="form-control required" name="accessoies" placeholder="Accessories">
                </div>
                <div class="form-group">
                    <label>Warranty/Chargable</label>
                    <input type="text" class="form-control required" name="warranty" placeholder="Warranty/Chargable">
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
    <script src="{{ asset('/js/common/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/common/common.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker();
        });
    </script>

@endsection