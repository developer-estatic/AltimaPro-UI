<header class="main-header">
    <nav class="navbar navbar-static-top header-menu">
        <div class="nav-top">
            <div class="container-fluid no-padding">
                <div class="row flex-wrp">
                    <div class="col-md-8 col-sm-7 col-xs-8 left-section">
                        <div class="navbar-header">
                            <a href="{{ route('dashboard.index') }}" class="navbar-brand">
                                <span class="logo-icon">
                                    <img src="{{ asset('img/small-logo.svg') }}" alt="Logo" width="42" height="42">
                                </span>
                            </a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <form class="navbar-form navbar-left main-search-form" action="#" method="post">
                            @csrf
                            <div class="main-search">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Tp Number/email/phone">
                                    <span class="input-group-btn">
                                        <button class="btn" type="submit" id="search-btn"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-4 col-sm-5 col-xs-4 right-section">
                        @if(auth()->check())
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- Calendar -->
                                <li class="dropdown header-icon">
                                    <a href="#" title="Calendar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
                                            <g clip-path="url(#clip0_413_1271)">
                                                <path d="M13.0554 2.1H11.4554V0.5H9.85537V2.1H5.05537V0.5H3.45537V2.1H1.85537C0.972971 2.1 0.255371 2.8176 0.255371 3.7V14.9C0.255371 15.7824 0.972971 16.5 1.85537 16.5H13.0554C13.9378 16.5 14.6554 15.7824 14.6554 14.9V3.7C14.6554 2.8176 13.9378 2.1 13.0554 2.1ZM13.0562 14.9H1.85537V5.3H13.0554L13.0562 14.9Z" fill="white"></path>
                                                <path d="M4.479 5.62012H6.783V8.18012H4.479V5.62012Z" fill="white"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_413_1271">
                                                    <rect width="14.4" height="16" fill="white" transform="translate(0.255371 0.5)"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </a>
                                </li>
                                
                                <!-- Inbox -->
                                <li class="dropdown header-icon">
                                    <a href="#" title="Inbox">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="13" viewBox="0 0 17 13" fill="none">
                                            <path d="M15.1125 0.785645H1.39823C1.09512 0.785645 0.804433 0.906052 0.590106 1.12038C0.375779 1.33471 0.255371 1.6254 0.255371 1.9285V11.0714C0.255371 11.3745 0.375779 11.6652 0.590106 11.8795C0.804433 12.0938 1.09512 12.2142 1.39823 12.2142H15.1125C15.4156 12.2142 15.7063 12.0938 15.9206 11.8795C16.135 11.6652 16.2554 11.3745 16.2554 11.0714V1.9285C16.2554 1.6254 16.135 1.33471 15.9206 1.12038C15.7063 0.906052 15.4156 0.785645 15.1125 0.785645ZM13.8554 1.9285L8.25537 5.80279L2.65537 1.9285H13.8554ZM1.39823 11.0714V2.4485L7.92966 6.9685C8.02531 7.03486 8.13895 7.07042 8.25537 7.07042C8.37179 7.07042 8.48543 7.03486 8.58109 6.9685L15.1125 2.4485V11.0714H1.39823Z" fill="white"></path>
                                        </svg>
                                    </a>
                                </li>
                                
                                <!-- Notifications -->
                                <li class="dropdown notifications-menu header-icon">
                                    <a href="javascript:void(0);" title="Notifications">
                                        <span class="notification-number">1</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" viewBox="0 0 15 17" fill="none">
                                            <path d="M14.8382 10.5925L13.3447 9.09904V7.12059C13.343 5.75335 12.8344 4.43531 11.9172 3.42133C11.0001 2.40735 9.73951 1.76946 8.3793 1.63102V0.5H7.27586V1.63102C5.91565 1.76946 4.65508 2.40735 3.73791 3.42133C2.82075 4.43531 2.31213 5.75335 2.31042 7.12059V9.09904L0.816926 10.5925C0.713452 10.696 0.655305 10.8363 0.655273 10.9826V12.6377C0.655273 12.7841 0.7134 12.9244 0.816867 13.0279C0.920334 13.1313 1.06067 13.1895 1.20699 13.1895H5.069V13.6181C5.057 14.3181 5.3037 14.9978 5.76184 15.5271C6.21997 16.0564 6.85731 16.398 7.55172 16.4865C7.93526 16.5246 8.32252 16.4819 8.68858 16.3613C9.05464 16.2407 9.39141 16.0448 9.67722 15.7862C9.96303 15.5276 10.1916 15.2121 10.3481 14.8599C10.5046 14.5077 10.5857 14.1266 10.5862 13.7412V13.1895H14.4482C14.5945 13.1895 14.7348 13.1313 14.8383 13.0279C14.9418 12.9244 14.9999 12.7841 14.9999 12.6377V10.9826C14.9999 10.8363 14.9417 10.696 14.8382 10.5925ZM9.48273 13.7412C9.48273 14.1802 9.30835 14.6011 8.99795 14.9115C8.68755 15.2219 8.26655 15.3963 7.82758 15.3963C7.38861 15.3963 6.96761 15.2219 6.65721 14.9115C6.34681 14.6011 6.17243 14.1802 6.17243 13.7412V13.1895H9.48273V13.7412ZM13.8965 12.086H1.75871V11.211L3.2522 9.71752C3.35567 9.61407 3.41382 9.47377 3.41385 9.32745V7.12059C3.41385 5.95 3.87887 4.82735 4.7066 3.99961C5.53434 3.17188 6.65699 2.70686 7.82758 2.70686C8.99817 2.70686 10.1208 3.17188 10.9486 3.99961C11.7763 4.82735 12.2413 5.95 12.2413 7.12059V9.32745C2.2413 9.47377 12.2995 9.61407 12.403 9.71752L13.8965 11.211V12.086Z" fill="white"></path>
                                        </svg>
                                    </a>
                                </li>
                                
                                <!-- User Menu -->
                                <li class="dropdown user user-menu header-icon">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Profile">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                            <path d="M8 0.5C3.5816 0.5 0 4.0816 0 8.5C0 12.9184 3.5816 16.5 8 16.5C12.4184 16.5 16 12.9184 16 8.5C16 4.0816 12.4184 0.5 8 0.5ZM8 2.7C9.436 2.7 10.6 3.864 10.6 5.3C10.6 6.736 9.436 7.9 8 7.9C6.564 7.9 5.4 6.736 5.4 5.3C5.4 3.864 6.564 2.7 8 2.7ZM8 14.9C5.784 14.9 3.832 13.7736 2.6832 12.0624C3.58 10.7584 6.4368 10.1 8 10.1C9.5632 10.1 12.42 10.7584 13.3168 12.0624C12.168 13.7736 10.216 14.9 8 14.9Z" fill="white"></path>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu user-dropdown">
                                        <li class="user-header">
                                            <span class="radius-box"><i class="fa fa-user"></i></span>
                                            <p>
                                                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                                <small class="designation">{{ auth()->user()->email }}</small>
                                            </p>
                                        </li>
                                        <li class="user-footer">
                                            <div class="user-box">
                                                <div><span class="new-icon user"></span></div>
                                                <div>
                                                    <h4>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                                                    <h6>{{ auth()->user()->email }}</h6>
                                                </div>
                                            </div>
                                            <div class="user-box profile clearfix">
                                                <div class="col-xs-6">
                                                    <a href="{{ route('settings.general.index') }}" class="btn btn-default btn-flat">My Profile</a>
                                                </div>
                                                <div class="col-xs-6 text-right">
                                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-default btn-flat">Log out</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                
                                <!-- Language Selector -->
                                <li class="dropdown lang-dropdown">
                                    <form id="langform" action="{{ route('language') }}" method="get" class="lang-form">
                                        <select class="form-control lang-select" name="lang" id="lang" onchange="this.form.submit()">
                                            <option value="en" data-flag="🇬🇧" @if(Session::get('locale', 'en') == 'en') selected @endif>🇬🇧 EN</option>
                                            <option value="fr" data-flag="🇫🇷" @if(session('locale') == 'fr') selected @endif>🇫🇷 FR</option>
                                            <option value="pt" data-flag="🇵🇹" @if(session('locale') == 'pt') selected @endif>🇵🇹 PT</option>
                                            <option value="ar" data-flag="🇸🇦" @if(session('locale') == 'ar') selected @endif>🇸🇦 AR</option>
                                            <option value="it" data-flag="🇮🇹" @if(session('locale') == 'it') selected @endif>🇮🇹 IT</option>
                                        </select>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
