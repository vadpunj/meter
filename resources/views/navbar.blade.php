<header class="app-header navbar">
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">
    <img class="navbar-brand-full" src="{{ asset('admin/img/Logo.png') }}" width="89" height="25" alt="CoreUI Logo">
    <img class="navbar-brand-minimized" src="{{ asset('admin/img/Logo.png') }}" width="30" height="30" alt="CoreUI Logo">
  </a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" style="padding-right:20px;" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-header text-center">
          <strong>Account</strong>
        </div>
        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
          <i class="fa fa-lock"></i> Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
              @csrf
          </form>
      </div>
    </li>
  </ul>
</header>
