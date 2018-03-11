@if (Request::segment(3) != "edit")
    <ol class="breadcrumb">
        <li><a href="/{{Request::segment(1)}}"><i class="fa fa-users"></i> {{ucwords(str_replace('-', ' ', Request::segment(1)))}} </a></li>
            <li><a href="/{{Request::segment(1)}}/{{Request::segment(2)}}/"><i class="fa fa-user"></i> {{ucwords(str_replace('-', ' ', Request::segment(2)))}} </a></li>
        @if (Request::segment(4))
            <li><a href="javascript:;"><i class="fa fa-pencil"></i> {{ucwords(str_replace('-', ' ', Request::segment(4)))}} </a></li>
        @else
            @if(Request::segment(3) || Request::segment(3) == "create")
                <li><a href="javascript:;"><i class="fa fa-plus"></i> {{ucwords(str_replace('-', ' ', Request::segment(3)))}} </a></li>
            @elseif (Route::currentRouteName() == Request::segment(2).".show")
                <li><a href="javascript:;"><i class="fa fa-eye"></i> {{ucwords(str_replace('-', ' ','show'))}} </a></li>
            @endif
        @endif
    </ol>
@endif