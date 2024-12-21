<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">UI Elements</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customer') }}">
                <i class="menu-icon mdi mdi-calendar-check"></i>
                <span class="menu-title">All Bookings</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contact.index') }}">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Report</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('commercial.index') }}">
                <i class="menu-icon mdi mdi-help-circle"></i>
                <span class="menu-title">Commercial Qoutes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('subscribe.index') }}">
                <i class="menu-icon mdi mdi-bell"></i>
                <span class="menu-title">Subscribe</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subscriptions.index') }}">
                <i class="menu-icon mdi mdi-bell"></i>
                <span class="menu-title">Stripe Subscribe</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.password.change') }}">
                <i class="menu-icon mdi mdi-lock"></i>
                <span class="menu-title">Password Change</span>
            </a>
        </li>
    </ul>
</nav>
