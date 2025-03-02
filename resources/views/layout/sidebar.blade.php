<div class="sidebar">
    <h4 class="sidebar-title">📊 Dashboard</h4>
    <ul class="sidebar-menu">
        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="{{route('users.index')}}"><i class="fas fa-user-tie"></i> landord</a></li>
        <li><a href="#"><i class="fas fa-users"></i>Renters</a></li>
        <li><a href="{{route('properties.index')}}"><i class="fas fa-building"></i>Properties</a></li>
        <li><a href="{{--{{route('contracts.index')}}--}}"><i class="fas fa-calendar-check"></i>Booking</a></li>
        <li><a href="#"><i class="fas fa-history"></i>History</a></li>
        <li><a href="#"><i class="fas fa-cog"></i>Settings</a></li>
        <li><a href="#"><i class="fas fa-phone"></i>Contact</a></li>
        <li><a href="#"><i class="fas fa-info-circle"></i>About</a></li>

        <div class="auth-links">
            @guest
                <li class="auth-links"><a href="/login">👤 Login</a></li>
                <li class="auth-links"><a href="/users/create">👤 Register</a></li>
            @endguest
            @auth
                <li class="auth-links"><a href="/logout">🚪 Logout</a></li>
            @endauth
        </div>
    </ul>
</div>
