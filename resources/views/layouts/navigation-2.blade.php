<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- New Navigation Menu Starts -->
    <div class="crm-nav-wrapper"> <!-- crm-open-nav-menu -->
        <div class="crm-nav-container">

            <div class="crm-nav-left relative">
                <ul>
                    @foreach($menu as $item)
                    <li>
                        <a href="{{ ($item->route) ? route($item->route) : 'javascript:void(0);' }}" class="{{ ($item->active) ? 'active': '' }} !no-underline">
                            {{ __($item->name) }}
                            @if($item->children->isNotEmpty())
                            <span>
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_288_8939)">
                                        <g clip-path="url(#clip1_288_8939)">
                                            <path d="M4.20099 2.89878L6.9511 0.205039C7.07365 0.0849362 7.26974 0.0861617 7.39229 0.20749L7.87393 0.689127C7.99648 0.812907 7.99648 1.01144 7.8727 1.134L4.42281 4.56183C4.36153 4.62311 4.28187 4.65375 4.20099 4.65375C4.1201 4.65375 4.04044 4.62311 3.97916 4.56183L0.529268 1.134C0.405488 1.01144 0.405488 0.812907 0.528042 0.689127L1.00968 0.20749C1.13223 0.0861617 1.32832 0.0849362 1.45087 0.205039L4.20099 2.89878Z" fill="#001D3D" />
                                        </g>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_288_8939">
                                            <rect width="8" height="4.8" fill="white" transform="translate(0 0.100098)" />
                                        </clipPath>
                                        <clipPath id="clip1_288_8939">
                                            <rect width="8" height="4.8" fill="white" transform="translate(0 0.100098)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            @endif
                        </a>
                        @if($item->children->isNotEmpty())
                            <ul class="absolute z-99">
                                @foreach($item->children as $child)
                                    <li><a class="text-capitalize" href="{{ ($child->route) ? route($child->route) : 'javascript:void(0);' }}">{{ __($child->name) }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="crm-nav-right">
                <div class="crm-nav-search-block">
                    <input placeholder="{{ __('TP No. / Email / Phone') }}" class="crm-input" type="search" name="" id="" value="" />
                    <span>
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.6356 7.0449C11.6356 7.71342 11.5039 8.37539 11.2481 8.99303C10.9923 9.61066 10.6173 10.1719 10.1446 10.6446C9.67186 11.1173 9.11066 11.4923 8.49303 11.7481C7.87539 12.0039 7.21342 12.1356 6.5449 12.1356C5.87637 12.1356 5.2144 12.0039 4.59676 11.7481C3.97913 11.4923 3.41793 11.1173 2.94521 10.6446C2.4725 10.1719 2.09752 9.61066 1.84169 8.99303C1.58585 8.37539 1.45418 7.71342 1.45418 7.0449C1.45418 5.69475 1.99052 4.39991 2.94521 3.44521C3.89991 2.49052 5.19475 1.95418 6.5449 1.95418C7.89504 1.95418 9.18988 2.49052 10.1446 3.44521C11.0993 4.39991 11.6356 5.69475 11.6356 7.0449ZM10.6306 12.1589C9.32358 13.203 7.6664 13.7071 5.99936 13.5676C4.33233 13.4281 2.78199 12.6556 1.66674 11.4087C0.551486 10.1619 -0.0440142 8.53529 0.00253724 6.86307C0.0490887 5.19086 0.734158 3.59994 1.91705 2.41705C3.09994 1.23416 4.69086 0.549089 6.36307 0.502537C8.03529 0.455986 9.66186 1.05149 10.9087 2.16674C12.1556 3.28199 12.9281 4.83233 13.0676 6.49936C13.2071 8.1664 12.703 9.82358 11.6589 11.1306L15.7867 15.2569C15.8543 15.3246 15.908 15.4048 15.9446 15.4932C15.9812 15.5815 16 15.6762 16 15.7718C16 15.8675 15.9812 15.9621 15.9446 16.0505C15.908 16.1388 15.8543 16.2191 15.7867 16.2867C15.7191 16.3543 15.6388 16.408 15.5505 16.4446C15.4621 16.4812 15.3675 16.5 15.2718 16.5C15.1762 16.5 15.0815 16.4812 14.9932 16.4446C14.9048 16.408 14.8246 16.3543 14.7569 16.2867L10.6306 12.1589Z" fill="#001D3D" />
                        </svg>
                    </span>
                </div>
            </div>

        </div>
    </div>
    <!-- NewNavigation Menu Ends -->
</nav>
