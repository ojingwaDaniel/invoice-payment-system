<div class="header">
    <div class="main-header">

       

        <!-- Sidebar Toggle -->
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <div class="header-user">
            <div class="nav user-menu nav-list">
                <div class="me-auto d-flex align-items-center" id="header-search">

                    <!-- Quick Add -->
                    <div class="dropdown me-3">
                        <a class="btn btn-primary bg-gradient btn-xs btn-icon rounded-circle d-flex align-items-center justify-content-center"
                           data-bs-toggle="dropdown" href="#" role="button">
                            <i class="isax isax-add text-white"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-start p-2">
                            <li><a href="{{ url('add-invoice') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-text-1 me-2"></i>Invoice
                            </a></li>
                            <li><a href="{{ url('expenses') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-send me-2"></i>Expense
                            </a></li>
                        </ul>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-divide mb-0">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a href="{{ url('/') }}">
                                    <i class="isax isax-home-2 me-1"></i>Home
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>

                </div>

                <div class="d-flex align-items-center">

                    <!-- Search -->
                    <div class="input-icon-end position-relative me-2">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-icon-addon">
                            <i class="isax isax-search-normal"></i>
                        </span>
                    </div>

                    <!-- Notifications -->
                    <div class="notification_item me-2">
                        <a href="#" class="btn btn-menubar position-relative" id="notification_popup" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="isax isax-notification-bing5"></i>
                            <span class="position-absolute badge bg-success border border-white"></span>
                        </a>
                        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                            <div class="p-2 border-bottom">
                                <h6 class="m-0 fs-16 fw-semibold">Notifications</h6>
                            </div>
                            <div class="notification-body" data-simplebar="">
                                <div class="dropdown-item notification-item py-2 text-wrap border-bottom">
                                    <p class="mb-0">No new notifications.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Light/Dark Mode -->
                    <div class="me-2 theme-item">
                        <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle btn btn-menubar">
                            <i class="isax isax-moon"></i>
                        </a>
                        <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle btn btn-menubar">
                            <i class="isax isax-sun-1"></i>
                        </a>
                    </div>

                    <!-- User Dropdown -->
                    @auth
                        <div class="dropdown profile-dropdown">
                            <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <span class="avatar online">
                                    <img src="{{ Auth::user()->profile_photo_url ?? asset('img/profiles/avatar-01.jpg') }}"
                                         alt="User" class="img-fluid rounded-circle">
                                </span>
                            </a>
                            <div class="dropdown-menu p-2">
                                <div class="d-flex align-items-center bg-light rounded-1 p-2 mb-2">
                                    <span class="avatar avatar-lg me-2">
                                        <img src="{{ Auth::user()->profile_photo_url ?? asset('img/profiles/avatar-01.jpg') }}"
                                             alt="User" class="rounded-circle">
                                    </span>
                                    <div>
                                        <h6 class="fs-14 fw-medium mb-1">{{ Auth::user()->company_name}}</h6>
                                        <p class="fs-13 text-muted mb-0">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="isax isax-profile-circle me-2"></i>Profile Settings
                                </a>
                                <hr class="dropdown-divider my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                        <i class="isax isax-logout me-2"></i>Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary ms-2">Login</a>
                    @endguest

                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu profile-dropdown">
            <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <span class="avatar avatar-md online">
                    <img src="{{ asset('img/profiles/avatar-01.jpg') }}" class="img-fluid rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu p-2 mt-0">
                <a class="dropdown-item d-flex align-items-center" href="">
                    <i class="isax isax-profile-circle me-2"></i>Profile Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                        <i class="isax isax-logout me-2"></i>Signout
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
