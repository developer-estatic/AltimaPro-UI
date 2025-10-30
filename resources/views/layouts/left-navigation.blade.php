@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside class="left-navigation">
    <ul>
        @if(isset($menu))
            @foreach ($menu as $item)
                @php
                    $isActiveMain = $item->route === $currentRoute || 
                        $item->children->contains(fn($c) => $c->route === $currentRoute || 
                        $c->children->contains('route', $currentRoute));
                    $hasChildren = $item->children->isNotEmpty();
                @endphp
                
                @if ($item->route && ((auth()->check() && auth()->user()->hasRoleId(1)) || hasPermission($item->route)))
                    <li class="parent {{ $isActiveMain ? 'active' : '' }}">
                        <a class="ln-drop-down" href="{{ !$hasChildren && $item->route ? route($item->route) : 'javascript:void(0);' }}">
                            @php
                                $iconClass = $item->icon ?? 'circle';
                                
                                // Map database icon names to Font Awesome icon classes
                                $iconMap = [
                                    'dashboard' => 'fa-dashboard',
                                    'settings' => 'fa-cog',
                                    'log-viewer' => 'fa-list-alt',
                                    'trading-accounts' => 'fa-users',
                                ];
                                
                                // Use mapped icon if exists, otherwise use the original
                                if (isset($iconMap[$iconClass])) {
                                    $iconClass = $iconMap[$iconClass];
                                } elseif (!str_starts_with($iconClass, 'fa-')) {
                                    // Add fa- prefix if not already present
                                    $iconClass = 'fa-' . $iconClass;
                                }
                            @endphp
                            <i class="fa {{ $iconClass }}"></i>
                            <abbr>{{ $item->name }}</abbr>
                        </a>
                        
                        @if($hasChildren)
                            <div class="submenu-wrapper">
                                <ul>
                                    <li><h3>{{ $item->name }}</h3></li>
                                    @foreach ($item->children as $child)
                                        @php
                                            $hasSubChildren = $child->children->isNotEmpty();
                                            $isActiveChild = $child->route === $currentRoute || 
                                                $child->children->contains('route', $currentRoute);
                                        @endphp
                                        
                                        @if ($child->route && ((auth()->check() && auth()->user()->hasRoleId(1)) || hasPermission($child->route)))
                                            <li class="{{ $isActiveChild ? 'active' : '' }} {{ $hasSubChildren ? 'sm-menu' : '' }}">
                                                <a href="{{ !$hasSubChildren && $child->route ? route($child->route) : 'javascript:void(0);' }}">
                                                    {{ $child->name }}
                                                </a>
                                                
                                                @if($hasSubChildren)
                                                    <ul class="ln-submenu">
                                                        @foreach ($child->children as $subChild)
                                                            @if ($subChild->route && ((auth()->check() && auth()->user()->hasRoleId(1)) || hasPermission($subChild->route)))
                                                                <li class="{{ $subChild->route === $currentRoute ? 'active' : '' }}">
                                                                    <a href="{{ route($subChild->route) }}">
                                                                        {{ $subChild->name }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endif
            @endforeach
        @else
            <li class="parent {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <a class="ln-drop-down" href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <abbr>Dashboard</abbr>
                </a>
            </li>
            <li class="parent {{ request()->routeIs('trading-accounts.index') ? 'active' : '' }}">
                <a class="ln-drop-down" href="{{ route('trading-accounts.index') }}">
                    <i class="fa fa-users"></i>
                    <abbr>Accounts</abbr>
                </a>
            </li>
            <li class="parent {{ request()->routeIs('settings.general.index') ? 'active' : '' }}">
                <a class="ln-drop-down" href="{{ route('settings.general.index') }}">
                    <i class="fa fa-cog"></i>
                    <abbr>Settings</abbr>
                </a>
            </li>
        @endif
    </ul>
    
    <div class="clearfix"></div>
    <div class="expand-btn" onclick="toggleExpandSidebar()">
        <i class="fa fa-expand" aria-hidden="true"></i>
    </div>
</aside>

<script>
function toggleExpandSidebar() {
    const sidebar = document.querySelector('.left-navigation');
    const expandBtn = document.querySelector('.expand-btn i');
    const body = document.body;
    
    if (sidebar.classList.contains('expand-menu')) {
        // Collapse
        sidebar.classList.remove('expand-menu');
        body.classList.remove('expand-menu');
        expandBtn.classList.remove('fa-compress');
        expandBtn.classList.add('fa-expand');
    } else {
        // Expand
        sidebar.classList.add('expand-menu');
        body.classList.add('expand-menu');
        expandBtn.classList.remove('fa-expand');
        expandBtn.classList.add('fa-compress');
    }
}
</script>
