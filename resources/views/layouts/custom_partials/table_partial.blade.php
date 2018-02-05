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