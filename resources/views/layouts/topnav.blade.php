<div class="header">
    <div class="main-header">

        <!-- Logo -->
        <div class="header-left">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo">
            </a>
            <a href="{{ url('/') }}" class="dark-logo">
                <img src="{{ asset('img/logo-white.svg') }}" alt="Logo">
            </a>
        </div>

        <!-- Sidebar Menu Toggle Button -->
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

                    <!-- Add -->
                    <div class="dropdown me-3">
                        <a class="btn btn-primary bg-gradient btn-xs btn-icon rounded-circle d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                            <i class="isax isax-add text-white"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-start p-2">
                            <li><a href="{{ url('add-invoice') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-text-1 me-2"></i>Invoice
                            </a></li>
                            <li><a href="{{ url('expenses') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-send me-2"></i>Expense
                            </a></li>
                            <li><a href="{{ url('add-credit-notes') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-add me-2"></i>Credit Notes
                            </a></li>
                            <li><a href="{{ url('add-debit-notes') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-money-recive me-2"></i>Debit Notes
                            </a></li>
                            <li><a href="{{ url('add-purchases-orders') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document me-2"></i>Purchase Order
                            </a></li>
                            <li><a href="{{ url('add-quotation') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-download me-2"></i>Quotation
                            </a></li>
                            <li><a href="{{ url('add-delivery-challan') }}" class="dropdown-item d-flex align-items-center">
                                <i class="isax isax-document-forward me-2"></i>Delivery Challan
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
                    <!-- /Search -->

                


                    <!-- Notification -->
                    <div class="notification_item me-2">
                        <a href="#" class="btn btn-menubar position-relative" id="notification_popup" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="isax isax-notification-bing5"></i>
                            <span class="position-absolute badge bg-success border border-white"></span>
                        </a>
                        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
                            <div class="p-2 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-body" data-simplebar="">
                                <!-- Example Notification -->
                                <div class="dropdown-item notification-item py-2 text-wrap border-bottom">
                                    <div class="d-flex">
                                        <div class="me-2 flex-shrink-0">
                                            <img src="{{ asset('img/profiles/avatar-05.jpg') }}" class="avatar-md rounded-circle" alt="User Img">
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0 fw-semibold text-dark">John Smith</p>
                                            <p class="mb-1 text-wrap fs-14">A <span class="fw-semibold">new sale</span> has been recorded.</p>
                                            <span class="fs-12"><i class="isax isax-clock me-1"></i>4 min ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 border-top text-center">
                                <a href="{{ url('notifications') }}" class="fw-medium fs-14">View All</a>
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
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="avatar online">
                                <img src="{{ asset('img/profiles/avatar-01.jpg') }}" alt="Img" class="img-fluid rounded-circle">
                            </span>
                        </a>
                        <div class="dropdown-menu p-2">
                            <div class="d-flex align-items-center bg-light rounded-1 p-2 mb-2">
                                <span class="avatar avatar-lg me-2">
                                    <img src="{{ asset('img/profiles/avatar-01.jpg') }}" alt="img" class="rounded-circle">
                                </span>
                                <div>
                                    <h6 class="fs-14 fw-medium mb-1">Jafna Cremson</h6>
                                    <p class="fs-13">Administrator</p>
                                </div>
                            </div>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('account-settings') }}">
                                <i class="isax isax-profile-circle me-2"></i>Profile Settings
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('inventory-report') }}">
                                <i class="isax isax-document-text me-2"></i>Reports
                            </a>
                            <hr class="dropdown-divider my-2">
                            <a class="dropdown-item logout d-flex align-items-center" href="{{ url('login') }}">
                                <i class="isax isax-logout me-2"></i>Sign Out
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu profile-dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <span class="avatar avatar-md online">
                    <img src="{{ asset('img/profiles/avatar-01.jpg') }}" alt="Img" class="img-fluid rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu p-2 mt-0">
                <a class="dropdown-item d-flex align-items-center" href="{{ url('profile') }}">
                    <i class="isax isax-profile-circle me-2"></i>Profile Settings
                </a>
                <a class="dropdown-item logout d-flex align-items-center" href="{{ url('login') }}">
                    <i class="isax isax-logout me-2"></i>Signout
                </a>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>
</div>
