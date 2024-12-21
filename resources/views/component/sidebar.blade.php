<!-- sidebar -->
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="" class="logo">Booking Lapangan</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="">BL</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Website</li>
            <li class="{{ Request::is('bookings-admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('booking-admin')}}">
                    <i class="fas fa-clipboard"></i> <span>Booking</span>
                </a>
            </li>
            <li class="{{ Request::is('lapangan-admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{route('lapangan-page')}}">
                    <i class="fas fa-clipboard"></i> <span>Lapangan</span>
                </a>
            </li>
        </li>
    </ul>
  </aside>
</div>
<!-- end sidebar -->
