<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Admin Panel</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/admin-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/admin-assets/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .badge-counter {
            position: absolute;
            transform: scale(.7);
            transform-origin: top right;
            right: .25rem;
            margin-top: -.25rem;
        }
        
        .inquiry-notification {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SolutionsForYou</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Content Management
            </div>

            <!-- Nav Item - Services -->
            <li class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServices"
                    aria-expanded="true" aria-controls="collapseServices">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Services</span>
                </a>
                <div id="collapseServices" class="collapse {{ request()->routeIs('services.*') ? 'show' : '' }}" aria-labelledby="headingServices" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Service Management:</h6>
                        <a class="collapse-item {{ request()->routeIs('services.index') ? 'active' : '' }}" href="{{ route('services.index') }}">
                            <i class="fas fa-list me-1"></i> All Services
                        </a>
                        <a class="collapse-item {{ request()->routeIs('services.create') ? 'active' : '' }}" href="{{ route('services.create') }}">
                            <i class="fas fa-plus me-1"></i> Add New Service
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Projects -->
            <li class="nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProjects"
                    aria-expanded="true" aria-controls="collapseProjects">
                    <i class="fas fa-fw fa-project-diagram"></i>
                    <span>Projects</span>
                </a>
                <div id="collapseProjects" class="collapse {{ request()->routeIs('projects.*') ? 'show' : '' }}" aria-labelledby="headingProjects" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Project Management:</h6>
                        <a class="collapse-item {{ request()->routeIs('projects.index') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                            <i class="fas fa-list me-1"></i> All Projects
                        </a>
                        <a class="collapse-item {{ request()->routeIs('projects.create') ? 'active' : '' }}" href="{{ route('projects.create') }}">
                            <i class="fas fa-plus me-1"></i> Add New Project
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Blogs -->
            <li class="nav-item {{ request()->routeIs('blogs.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBlogs"
                    aria-expanded="true" aria-controls="collapseBlogs">
                    <i class="fas fa-fw fa-blog"></i>
                    <span>Blog</span>
                </a>
                <div id="collapseBlogs" class="collapse {{ request()->routeIs('blogs.*') ? 'show' : '' }}" aria-labelledby="headingBlogs" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Blog Management:</h6>
                        <a class="collapse-item {{ request()->routeIs('blogs.index') ? 'active' : '' }}" href="{{ route('blogs.index') }}">
                            <i class="fas fa-list me-1"></i> All Posts
                        </a>
                        <a class="collapse-item {{ request()->routeIs('blogs.create') ? 'active' : '' }}" href="{{ route('blogs.create') }}">
                            <i class="fas fa-plus me-1"></i> Add New Post
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Inquiries -->
            @php
                $unreadInquiries = \App\Models\ServiceInquiry::where('status', 'pending')->count();
                $totalSubscribers = \App\Models\Subscriber::where('status', 'active')->count();
                $newContacts = \App\Models\Contact::where('status', 'new')->count();
            @endphp
            <li class="nav-item {{ request()->routeIs('inquiries.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('inquiries.index') }}">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Service Inquiries</span>
                    @if($unreadInquiries > 0)
                        <span class="badge badge-danger badge-counter inquiry-notification">{{ $unreadInquiries }}</span>
                    @endif
                </a>
            </li>

            <!-- Nav Item - Contact Messages -->
            <li class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Contact Messages</span>
                    @if($newContacts > 0)
                        <span class="badge badge-primary badge-counter">{{ $newContacts }}</span>
                    @endif
                </a>
            </li>

            <!-- Nav Item - Subscribers -->
            <li class="nav-item {{ request()->routeIs('subscribers.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubscribers"
                    aria-expanded="true" aria-controls="collapseSubscribers">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Subscribers</span>
                    @if($totalSubscribers > 0)
                        <span class="badge badge-success badge-counter">{{ $totalSubscribers }}</span>
                    @endif
                </a>
                <div id="collapseSubscribers" class="collapse {{ request()->routeIs('subscribers.*') ? 'show' : '' }}" aria-labelledby="headingSubscribers" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Subscriber Management:</h6>
                        <a class="collapse-item {{ request()->routeIs('subscribers.index') ? 'active' : '' }}" href="{{ route('subscribers.index') }}">
                            <i class="fas fa-list me-1"></i> All Subscribers
                        </a>
                        <a class="collapse-item {{ request()->routeIs('subscribers.newsletter') ? 'active' : '' }}" href="{{ route('subscribers.newsletter') }}">
                            <i class="fas fa-paper-plane me-1"></i> Send Newsletter
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Finance
            </div>

            <!-- Nav Item - Payments -->
            @php
                $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
                $totalRevenue = \App\Models\Payment::where('status', 'paid')->sum('amount');
            @endphp
            <li class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Payments</span>
                    @if($pendingPayments > 0)
                        <span class="badge badge-warning badge-counter">{{ $pendingPayments }}</span>
                    @endif
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Website Management
            </div>

            <!-- Nav Item - Frontend -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}" target="_blank">
                    <i class="fas fa-fw fa-globe"></i>
                    <span>View Website</span>
                </a>
            </li>

            <!-- Nav Item - Admin Management -->
            <li class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.admins.index') }}">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Admin Management</span>
                </a>
            </li>

            <!-- Nav Item - Settings -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search services, inquiries..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>

                        <!-- Nav Item - Inquiries Alert -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="inquiriesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                @if($unreadInquiries > 0)
                                    <span class="badge badge-danger badge-counter">{{ $unreadInquiries }}</span>
                                @endif
                            </a>
                            <!-- Dropdown - Inquiries -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="inquiriesDropdown">
                                <h6 class="dropdown-header">
                                    Recent Inquiries
                                </h6>
                                @php
                                    $recentInquiries = \App\Models\ServiceInquiry::with('service')
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp
                                @forelse($recentInquiries as $inquiry)
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('inquiries.show', $inquiry->id) }}">
                                        <div class="mr-3">
                                            <div class="icon-circle {{ $inquiry->status === 'pending' ? 'bg-warning' : 'bg-success' }}">
                                                <i class="fas fa-envelope text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</div>
                                            <span class="font-weight-bold">{{ Str::limit($inquiry->name, 20) }}</span>
                                            <div class="small text-muted">{{ Str::limit($inquiry->service->title ?? 'Service', 25) }}</div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-center text-muted py-3">
                                        No inquiries yet
                                    </div>
                                @endforelse
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('inquiries.index') }}">
                                    View All Inquiries
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Auth::guard('admin')->user()->avatar_url }}"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="{{ url('/') }}" target="_blank">
                                    <i class="fas fa-globe fa-sm fa-fw mr-2 text-gray-400"></i>
                                    View Website
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="confirmLogout(event)">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

<script>
function confirmLogout(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Logout Confirmation',
        text: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Logout',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route('admin.logout') }}';
        }
    });
}
</script>