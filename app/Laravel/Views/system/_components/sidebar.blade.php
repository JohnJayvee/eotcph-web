<nav class="sidebar sidebar-offcanvas p-0" id="sidebar" style="background-color: #2D2F32;color: #ffff;">
  <h6 class="pl-3 pt-4">Navigation Bar</h6>
  <ul class="nav">
    
    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.dashboard')) ? 'active' : ''}}">
      <a class="nav-link" href="{{route('system.dashboard')}}">
        <i class="fa fa-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    @if(in_array($auth->type,['super_user','admin']))
    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.application.index','system.application.show')) ? 'active' : ''}}">
      <a class="nav-link" href="{{route('system.application.index')}}">
        <i class="fa fa-file menu-icon"></i>
        <span class="menu-title">Applications</span>
      </a>
    </li>
    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.department.index','system.department.create','system.department.edit')) ? 'active' : ''}}">
      <a class="nav-link" href="{{route('system.department.index')}}">
        <i class="fa fa-globe menu-icon"></i>
        <span class="menu-title">Departments</span>
      </a>
    </li>
    <li class="p-3 nav-item {{ in_array(Route::currentRouteName(), array('system.application_type.index','system.application_type.create','system.application_type.edit')) ? 'active' : ''}}">
      <a class="nav-link" href="{{route('system.application_type.index')}}">
        <i class="fa fa-bookmark menu-icon"></i>
        <span class="menu-title">Application Type</span>
      </a>
    </li>
    <li class="p-3 nav-item">
      <a class="nav-link" href="">
        <i class="fa fa-chart-line menu-icon"></i>
        <span class="menu-title">Reporting</span>
      </a>
    </li>
    @endif
  </ul>

</nav>