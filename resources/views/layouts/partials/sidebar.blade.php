<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/sharekhan_favi.jpeg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" id = "sidebar_search" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?php
            if (!isset(\Auth::user()->emp_id)) return;
            $user = \Auth::user()->emp_id;
            
            if($user == 11) {
                $data = generateSidebar();
            } else {
                $data = generateSidebarY();
            }
            $perm = permissionList();
            
        ?>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @foreach($data as $key => $val)
            <?php
                $tab_name = $key;
                $tab_url = str_replace(' ', '-', strtolower($tab_name));  
            ?>
            @if (true)
                <li class="treeview">
                    <a href="{{$val[0]['url']}}"><i class='fa {{$val[0]["icon"]}}' aria-hidden="true"></i><span>{{$tab_name}}</span><i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <?php  ?>
                        @foreach($val['inner_tab'] as $inner_key => $inner_tab)
                            
                                <li><a class = "{{$inner_tab['url']}}" href="{{ url($tab_url.'/'.$inner_tab['url']) }}"><i class='fa {{$inner_tab["icon"]}}' aria-hidden="true"></i>{{$inner_key}}</a></li>
                            
                        @endforeach
                    </ul>
                </li>
            @endif
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
