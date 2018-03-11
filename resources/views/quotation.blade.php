@extends('layouts.app')

@section('custom-styles')
    
    @include('layouts.style_loaders.token_loader')
    @include('layouts.style_loaders.datatable_loader')

@endsection

@section('htmlheader_title')
    {{ucwords(str_replace('-', ' ', Request::segment(1)))}} | {{ucwords(str_replace('-', ' ', Request::segment(2)))}}
@endsection

@section('contentheader_title')
    {{ucwords(str_replace('-', ' ', Request::segment(1)))}}
@endsection

@section('custom-breadcrumb')
    @include('layouts.custom_partials.breadcrumb')
@endsection

@section('contentheader_description')
    <!-- This is a test template -->
@endsection

@section('main-content')

    <div class="panel">
        <div class="panel-heading ">   
            <div class = "pull-right">
                <div class = "btn-group">
                    <a href="/{{Request::path()}}/create">
                        <button type="button" class="btn btn-sharekhan" data-original-title="Add Quotation" data-original-title="Add Quotation" data-toggle="tooltip" data-target="" title="Add Quotation" data-original-title="Add {{ucwords(str_replace('-', ' ', Request::segment(2)))}}">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add {{ucwords(str_replace('-', ' ', Request::segment(2)))}}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="panel-body padding_top_3">
            <table id="table" class="table display compact table-striped table-bordered  hover nowrap" cellspacing="0" role="grid" width="100%">
                <thead>
                    <tr>
                        @forEach($data['columns'] as $column)
                            <th class = "thead_{{$column}}">{{ucwords(str_replace('_', ' ', $column))}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        @forEach($data['columns'] as $key => $column)
                            @if(in_array($key ,$data['disable_footer_search']))
                                <th class = "tfoot_{{$column}} no-search"> {{ucwords(str_replace('_', ' ', $column))}} </th>
                            @else
                                <th class = "tfoot_{{$column}}"> {{ucwords(str_replace('_', ' ', $column))}} </th>
                            @endif
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection

@section('php-to-js')
    <?php
        $js_data = array();
        $js_data['env'] = env('APP_ENV');
        $js_data['columns'] = $data['columns'];
        $js_data['pk'] = $data['pk'];
        $js_data['status'] = config('constants.STATUS');
        $js_data['color'] = config('constants.COLOR_GENERAL');
    ?>
@endsection

@section('custom-scripts')

    @include('layouts.script_loaders.datatable_loader')
    @include('layouts.script_loaders.excel_loader')
    <script src="{{ asset('/js/common/bootbox.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var action_obj = [{
                class : "",
                title : "Edit",
                url : "/edit",
                href : true,
                i : {
                    class : "fa fa-pencil"
                }
            }, {
                class : "delete",
                title : "Delete",
                url : "",
                href : false,
                i : {
                    class : "fa fa-trash"
                }
            }];

            var datatable_object = {
                table_name : $('table').attr('id'),
                order : {
                    state: false,
                    column : 1,
                    mode : "asc"
                },
                buttons : {
                    state : true ,
                    colvis : true,
                    excel : {
                        state: true,
                        columns: [':visible'] 
                    },
                    pdf : {
                        state: true,
                        columns: [':visible'] 
                    },
                },
                info : true,
                paging : true,
                searching : true,
                ordering : true,
                iDisplayLength: 10,
                sort_disabled_targets : [],
                ajax_url : window.location.href,
                column_data : datatableColumn(lang.columns, action_obj, lang.pk),
            }

            table = datatableInitWithButtonsAndDynamicRev(datatable_object);
                        
            // statusChange();

            // delete call for customer
            $(document).on('click', '.delete', function() {
                var url = $(this).attr('data-url');
                // console.log(url)
                bootbox.confirm("Are you sure you want to delete this record!", function(result) { 
                    console.log('This was logged in the callback: ' + result);
                    // once ajax is fired will hit the destroy function of controller. No need for route
                    if(result) {
                        $.ajax({
                            url:url,
                            type:"DELETE",
                            success: function(res) {
                                location.reload();
                            }
                        })
                    } 
                });
            })

        });

    </script>

@endsection

