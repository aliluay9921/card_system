<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            Cards
            {{--            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">--}}
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            cards
{{--                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">--}}
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>


                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->


        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">

                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <ul class="navbar-nav">
                <li class="nav-item   ">
                    <a class="nav-link my-1 @yield('profile')" href="{{ route('profile.edit') }}">
                        <i class="ni ni-single-02 "></i>
                        الصفحه الشخصيه
                    </a>
                </li>


                @role('admin|super-admin')
                <li class="nav-item ">
                    <a class="nav-link my-1  @yield('report')" href="{{ route('log.index') }}">
                        <i class="ni ni-tv-2"></i>التقارير</a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link my-1  @yield('amount')" href="{{ route('amount.index') }}">
                        <i class="ni ni-money-coins"></i>الفئات</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link my-1  @yield('users')" href="{{ route('users.index') }}">
                        <i class="fas fa-users"></i>المستخدمين
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link my-1  @yield('card')" href="{{route('card.index')}}">
                        <i class="ni ni-credit-card"></i>
                        البطاقات
                    </a>

                </li>
                <li class="nav-item ">
                    <a class="nav-link my-1 @yield('virtualBalance')" href="{{route('virtualBalance.index')}}">
                        <i class="fas fa-money-bill-wave"></i>
                        الرصيد الافتراضي </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link my-1 @yield('ads')" href="{{route('ads.index')}}">
                        <i class="fas fa-tv"></i>
                        الاعلانات
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link my-1 @yield('order')" href="{{route('order.index')}}">
                        <i class="ni ni-send"></i>
                        الحوالات
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link my-1 @yield('company')" href="{{route('company.index')}}">
                        <i class="ni ni-building"></i>
                        الشركات
                    </a>
                </li>
                @endrole

            </ul>


        </div>
    </div>
</nav>
