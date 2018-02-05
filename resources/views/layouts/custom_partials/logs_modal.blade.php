<div class="modal fade modal-fullscreen force-fullscreen padding_left_0px padding_right_0px" id="log_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog logModal_body width_height_100_percent margin_0px_auto">
        <div class="modal-content border_radius " >
            <div class="modal-header bg-sharekhan border_radius_top clearfix" style="z-index: 1">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{$title}}</h4>
            </div>
        
            <div class="modal-body ">
                <div class="col-md-12" style="padding-top: 5%;">  
                        <?php $prefix = config('constants.EventStatusLog.prefix');?>
                        <table id="table_esl" class="table display compact table-striped table-bordered  hover nowrap" cellspacing="0" role="grid" width="100%">
                            <thead>
                                <tr>
                                    @forEach($data['columns_esl'] as $column)
                                        <th class = "thead_{{$column}}">{{ucwords(str_replace('_', ' ', $column))}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    @forEach($data['columns_esl'] as $key => $column)
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
            <div class="modal-footer">
                <button type="button" class="btn btn-sharekhan" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>