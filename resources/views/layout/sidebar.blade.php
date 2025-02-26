<div class="sidebar bg-dark text-white" id="sidebar" style="min-height: 100vh; width: 250px;">
    <!-- Toggle Button -->
    <button class="btn btn-dark d-block d-md-none" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <h4 class="sidebar-title p-3">Dashboard</h4>
    <ul class="sidebar-menu list-unstyled">
        <li class="p-2"><a href="#" class="text-white text-decoration-none">🏠 Home</a></li>
        <li class="p-2"><a href="{{ route('users.index') }}" class="text-white text-decoration-none">👨 All Users</a></li>
        <li class="p-2"><a href="#" class="text-white text-decoration-none">📦 Properties</a></li>
        <li class="p-2"><a href="#" class="text-white text-decoration-none">📅 Booking</a></li>
        <li class="p-2"><a href="#" class="text-white text-decoration-none">📜 History</a></li>
        <li class="p-2"><a href="#" class="text-white text-decoration-none">⚙️ Settings</a></li>
        <li class="p-2"><a href="#" class="text-white text-decoration-none">📞 Contact</a></li>
        <li class="p-2"><a href="#" class="text-white text-decoration-none">📝 About</a></li>

        <!-- Authentication Links -->
        <div class="mt-auto p-3">
            @guest
                <li class="p-2"><a href="#" class="text-white text-decoration-none">👤 Login</a></li>
                <li class="p-2"><a href="#" class="text-white text-decoration-none">👤 Register</a></li>
            @endguest
            @auth
                <li class="p-2">
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-white text-decoration-none p-0">🚪 Logout</button>
                    </form>
                </li>
            @endauth
        </div>
    </ul>
</div>
