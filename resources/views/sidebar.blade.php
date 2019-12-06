
<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <!-- <li class="nav-title">จัดการระบบ</li> -->
      <li class="nav-item">
        <a class="nav-link {{ (request()->is('/home')) ? 'active' : '' }}" href="{{ route('home') }}">
          <i class="nav-icon icon-pencil"></i> ศูนย์ต้นทุน</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->is('/branch')) ? 'active' : '' }}" href="{{ route('branch') }}">
          <i class="nav-icon icon-pencil"></i> สาขา</a>
      </li>
      <li class="nav-item nav-dropdown {{ (request()->is('/water/*')) ? 'show open' : '' }}">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-puzzle"></i> ค่าน้ำ</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('water/import')) ? 'active' : '' }}" href="{{ route('wimport') }}">
              <i class="nav-icon icon-doc"></i> import file</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('water/export_excel')) ? 'active' : '' }}" href="{{ route('wexport') }}">
              <i class="nav-icon icon-doc"></i> export file</a>
          </li>
        </ul>
      </li>
      {{--<li class="nav-item">
        <a class="nav-link {{ (request()->is('/list')) ? 'active' : '' }}" href="{{ route('list') }}">
          <i class="nav-icon icon-doc"></i> ดูข้อมูล</a>
      </li>--}}
      <li class="nav-item nav-dropdown {{ (request()->is('/electric/*')) ? 'show open' : '' }}">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-puzzle"></i> ค่าไฟ</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('electric/import')) ? 'active' : '' }}" href="{{ route('eimport') }}">
              <i class="nav-icon icon-doc"></i> import file</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('electric/export')) ? 'active' : '' }}" href="{{ route('eexport') }}">
              <i class="nav-icon icon-doc"></i> export file</a>
          </li>
        </ul>
      </li>
      {{--<li class="nav-item">
        <a class="nav-link {{ (request()->is('elect/import')) ? 'active' : '' }}" href="{{ route('eimport') }}">
          <i class="nav-icon icon-doc"></i> อ่านข้อมูล</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ (request()->is('elect/export')) ? 'active' : '' }}" href="{{ route('eexport') }}">
          <i class="nav-icon icon-doc"></i> Export files</a>
      </li>--}}
      @if(Auth::user()->type ==1)
      <li class="nav-item">
        <a class="nav-link" target="_blank" href="{{ route('register') }}" >
          <i class="nav-icon icon-doc"></i> Register</a>
      </li>
      @endif
    </ul>
  </nav>
</div>
