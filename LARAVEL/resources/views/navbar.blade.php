

<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <!-- Brand Section -->
      <div class="sidebar-brand">
        <a style="font-family: Courier Prime; font-size: 17px;" href="/">Your Account Keeper.</a>
        
      </div>

      <!-- User Info Section (name and status only) -->
        <div class="sidebar-header" style="width: 100%; text-align: center;">
            <div class="user-info" style="display: block; width: 100%; text-align: center;">
                <span class="user-name" style="font-family: Palatino Linotype; font-size: 30px; display: inline-block;">
                    {{ auth()->user()->name }}
                </span>
            </div>
        </div>




        <!-- Section with clickable icons for Profile, Notifications, Logout -->
        <div class="sidebar-header">
            <div class="icon-links">
                <!-- Icons section will now take up the full space and distribute evenly -->
                <a href="{{ route('profile.edit') }}" title="Profile">
                    <i class="fas fa-user-circle"></i>
                </a>
                <!-- <a href="{{ route('dashboard') }}" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-bubble">5</span> 
                </a> -->
                <!-- Hidden logout form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- Modified logout link -->
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>



      

      <!-- Sidebar Menu -->
      <div class="sidebar-menu">
        <ul>
          
          
          <!-- Dashboard Link -->
          <li class="sidebar">
            <a href="{{ route('dashboard') }}">
              <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
          </li>

          <!-- Invoices Dropdown -->
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-file-invoice"></i> Invoices
            </a>
            <div class="sidebar-submenu" style="font-size: 1px;">
              <ul style="font-size: 1px;">
                <li><a href="{{ route('invoice.index') }}" style="font-size: 17px;">All</a></li>
                <li><a href="{{ route('invoice.sent') }}" style="font-size: 17px;">Sent</a></li>
                <li><a href="{{ route('invoice.received') }}" style="font-size: 17px;">Received</a></li>
                <li><a href="{{ route('templates') }}" style="font-size: 17px;">Templates</a></li>
              </ul>
            </div>
          </li>

          <!-- Payments Dropdown -->
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-credit-card"></i> Payments
            </a>
            <div class="sidebar-submenu">
              <ul style="font-size: 10px;">
                
                <li><a href="{{ route('invoice.paid') }}" style="font-size: 17px;">Paid</a></li>
                <li><a href="{{ route('invoice.pending') }}" style="font-size: 17px;">Pending</a></li>
                <li><a href="{{ route('invoice.unpaid') }}" style="font-size: 17px;">Unpaid</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
  </nav>

  Main Content Area
    <main class="page-content">
    @yield('content')
    </main>

  
</div>

<!-- Include Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

