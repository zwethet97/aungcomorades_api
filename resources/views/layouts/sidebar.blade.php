<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Aungpwal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Main</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/betslips') }}" class="nav-link {{ Request::is('admin/betslips') ? 'active' : '' }}">
              <i class="nav-icon fas fa-scroll"></i>
              <p>
                BetSlips
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/users') }}" class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link menu-open">
              <i class="nav-icon fas fa-arrows-alt-h"></i>
              <p>
                Transaction
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/transaction/deposit') }}" class="nav-link {{ Request::is('admin/transaction/deposit') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Deposit Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/transaction/withdraw') }}" class="nav-link {{ Request::is('admin/transaction/withdraw') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Withdraw Request</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link menu-open">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Compensation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ url('/admin/compensate') }}" class="nav-link {{ Request::is('admin/compensate') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>D3D Compensate</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/compensate/round') }}" class="nav-link {{ Request::is('admin/compensate/round') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>D3D Round Compensate</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/compensate/twodview') }}" class="nav-link {{ Request::is('admin/compensate/twodview') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>D2D Compensate</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/tips') }}" class="nav-link {{ Request::is('admin/tips') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Tips
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/reward') }}" class="nav-link {{ Request::is('admin/reward') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Rewards/Referral Bonus
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/intro') }}" class="nav-link {{ Request::is('admin/intro') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Intro Banners
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/tipbanner') }}" class="nav-link {{ Request::is('admin/tipbanner') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Tip Banner
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/compensate/number') }}" class="nav-link {{ Request::is('admin/compensate/number') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Limit/Win Number
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>