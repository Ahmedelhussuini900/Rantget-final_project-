<div class="sidebar bg-dark" >
    <h4 class="sidebar-title">Dashboard</h4>
    <ul class="sidebar-menu">
        <li><a href="#">🏠 Home</a></li>
        <li><a href="#">👨 Owners</a></li>
        <li><a href="#">👥 Renters</a></li>
        <li><a href="#">📦 Properties</a></li>
        <li><a href="#">📅 Booking</a></li>
        <li><a href="#">📜 History</a></li>
        <li><a href="#">⚙️ Settings</a></li>
        <li><a href="#">📞 Contact</a></li>
        <li><a href="#">📝 About</a></li>
        <div style="padding-top: 100px; ;">
                @guest
                <li><a href="#">👤 Login</a></li>
                <li><a href="#">👤 Register</a></li>
                @endguest
                @auth
                <li><a href="#">🚪 Logout</a></li>
                @endauth
        </div>

    </ul>
</div>
