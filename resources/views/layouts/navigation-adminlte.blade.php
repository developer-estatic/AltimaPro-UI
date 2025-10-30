@php
    $currentRoute = Route::currentRouteName();
@endphp

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <i class="fa fa-user-circle" style="font-size: 45px; color: #fff;"></i>
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->first_name ?? 'User' }} {{ auth()->user()->last_name ?? '' }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            
            <!-- Dashboard -->
            <li class="{{ $currentRoute == 'dashboard.index' ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- Dynamic Menu from Database -->
            @if(isset($menu))
                @foreach ($menu as $item)
                    @php
                        $isActiveMain = $item->route === $currentRoute || 
                            $item->children->contains(fn($c) => $c->route === $currentRoute || 
                            $c->children->contains('route', $currentRoute));
                        $hasChildren = $item->children->isNotEmpty();
                    @endphp
                    
                    @if ($item->route && hasPermission($item->route))
                        @if($hasChildren)
                            <!-- Menu with Children -->
                            <li class="treeview {{ $isActiveMain ? 'active menu-open' : '' }}">
                                <a href="{{ $item->route ? route($item->route) : '#' }}">
                                    <i class="fa {{ $item->icon ?? 'fa-circle-o' }}"></i>
                                    <span>{{ $item->name }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu" style="{{ $isActiveMain ? 'display: block;' : '' }}">
                                    @foreach ($item->children as $child)
                                        @php
                                            $hasSubChildren = $child->children->isNotEmpty();
                                            $isActiveChild = $child->route === $currentRoute || 
                                                $child->children->contains('route', $currentRoute);
                                        @endphp
                                        
                                        @if (!$child->route || $child->route == '' || (isset($child->route) && hasPermission($child->route)))
                                            @if($hasSubChildren)
                                                <!-- Sub-menu with children -->
                                                <li class="treeview {{ $isActiveChild ? 'active menu-open' : '' }}">
                                                    <a href="{{ $child->route ? route($child->route) : '#' }}">
                                                        <i class="fa fa-circle-o"></i> {{ $child->name }}
                                                        <span class="pull-right-container">
                                                            <i class="fa fa-angle-left pull-right"></i>
                                                        </span>
                                                    </a>
                                                    <ul class="treeview-menu" style="{{ $isActiveChild ? 'display: block;' : '' }}">
                                                        @foreach ($child->children as $subChild)
                                                            @if ($subChild->route && hasPermission($subChild->route))
                                                                <li class="{{ $subChild->route === $currentRoute ? 'active' : '' }}">
                                                                    <a href="{{ route($subChild->route) }}">
                                                                        <i class="fa fa-angle-double-right"></i> {{ $subChild->name }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <!-- Simple sub-menu item -->
                                                <li class="{{ $child->route === $currentRoute ? 'active' : '' }}">
                                                    <a href="{{ route($child->route) }}">
                                                        <i class="fa fa-circle-o"></i> {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <!-- Simple Menu Item -->
                            <li class="{{ $isActiveMain ? 'active' : '' }}">
                                <a href="{{ route($item->route) }}">
                                    <i class="fa {{ $item->icon ?? 'fa-circle-o' }}"></i>
                                    <span>{{ $item->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif

            <!-- Static Menu Items (fallback if menu not loaded) -->
            @if(!isset($menu))
                <li class="{{ Request::is('*/accounts*') ? 'active' : '' }}">
                    <a href="{{ route('trading-accounts.index') }}">
                        <i class="fa fa-users"></i> <span>Trading Accounts</span>
                    </a>
                </li>
                
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>Settings</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('settings.general.index') }}"><i class="fa fa-circle-o"></i> General</a></li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

