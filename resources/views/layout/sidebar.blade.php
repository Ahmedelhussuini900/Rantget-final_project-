@if(auth()->check())
    <div class="sidebar">
        <h4 class="sidebar-title">📊 Dashboard</h4>
        <ul class="sidebar-menu">
            <li><a href="{{--{{ route('dashboard') }}--}}"><i class="fas fa-home"></i> Home</a></li>

            {{-- @if(auth()->user()->role == 'admin')
            <li><a href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> Manage Users</a></li>
            <li><a href="{{ route('properties.index') }}"><i class="fas fa-building"></i> All Properties</a></li>
            <li><a href="{{ route('contracts.index') }}"><i class="fas fa-file-contract"></i> All Contracts</a></li>
            <li><a href="{{ route('payments.index') }}"><i class="fas fa-dollar-sign"></i> Payments</a></li> --}}
        @if(auth()->user()->role == 'landlord')
            <li><a href="{{ route('properties.index') }}"><i class="fas fa-building"></i> Properties</a></li>
            <li><a href="{{ route('contracts.index') }}"><i class="fas fa-calendar-check"></i> Booking</a></li>
        @elseif(auth()->user()->role == 'renter')
            <li><a href="#"><i class="fas fa-home"></i> My Rentals</a></li>
            <li><a href="#"><i class="fas fa-history"></i> Payment History</a></li>
        @endif

            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="#"><i class="fas fa-phone"></i> Contact</a></li>
            <li><a href="#"><i class="fas fa-info-circle"></i> About</a></li>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>




        </ul>
    </div>
@endif
