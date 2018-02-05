@if (Request::segment(4))
        {{ucwords(str_replace('-', ' ', Request::segment(1)))}} | {{ucwords(str_replace('-', ' ', Request::segment(2)))}} | {{ucwords(str_replace('-', ' ', Request::segment(4)))}}
@else
    @if(Request::segment(3) == "create")
        {{ucwords(str_replace('-', ' ', Request::segment(1)))}} | {{ucwords(str_replace('-', ' ', Request::segment(2)))}} | {{ucwords(str_replace('-', ' ', Request::segment(3)))}}
    @else
        {{ucwords(str_replace('-', ' ', Request::segment(1)))}} | {{ucwords(str_replace('-', ' ', Request::segment(2)))}} | Show | {{ucwords(str_replace('-', ' ', isset($title) ? $title : ''))}}
    @endif
@endif