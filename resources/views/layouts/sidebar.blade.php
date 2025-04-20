<div class="sidebar">
  <!-- SidebarSearch Form -->
  <div class="form-inline mt-2">
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
  @if(Auth::check() && Auth::user()->tingkat == 'admin')
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">Profil</li>
      <li class="nav-item">
      <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu ==
    'profil') ? 'active' : '' }} ">
        <i class="nav-icon far fa-user"></i>
        <p>Profil</p>
      </a>
      </li>
      <li class="nav-header">Data Akun</li>
      <li class="nav-item">
      <a href="{{ url('/admin/akun') }}" class="nav-link {{ ($activeMenu == 'akun') ?
    'active' : '' }}">
        <i class="nav-icon far fa-list-alt"></i>
        <p>Data Akun</p>
      </a>
      </li>
      <li class="nav-header">Data Barang</li>
      <li class="nav-item">
      <a href="{{ url('/admin/barang') }}" class="nav-link {{ ($activeMenu ==
    'barang') ? 'active' : '' }} ">
        <i class="nav-icon far fa-list-alt"></i>
        <p>Data Barang</p>
      </a>
      </li>
      <li class="nav-header">Data Pembelian</li>
      <li class="nav-item">
      <a href="{{ url('/admin/pembelian') }}" class="nav-link {{ ($activeMenu ==
    'pembelian') ? 'active' : '' }} ">
        <i class="nav-icon fas fa-cash-register"></i>
        <p>Data Pembelian</p>
      </a>
      </li>
      <li class="nav-item">
      <a href="{{ url('/logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
      </li>
    </ul>
    </nav>
  @elseif(Auth::check() && Auth::user()->tingkat == 'user')
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">Profil</li>
      <li class="nav-item">
      <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu ==
    'profil') ? 'active' : '' }} ">
        <i class="nav-icon far fa-user"></i>
        <p>Profil</p>
      </a>
      </li>
      <li class="nav-header">Data Barang</li>
      <li class="nav-item">
      <a href="{{ url('/user/transaksi') }}" class="nav-link {{ ($activeMenu ==
    'barang') ? 'active' : '' }} ">
        <i class="nav-icon far fa-list-alt"></i>
        <p>Data Barang</p>
      </a>
      </li>
      <li class="nav-header">Data Pembelian</li>
      <li class="nav-item">
      <a href="{{ url('user/pembelian') }}" class="nav-link {{ ($activeMenu ==
    'pembelian') ? 'active' : '' }} ">
        <i class="nav-icon fas fa-cash-register"></i>
        <p>Data Pembelian</p>
      </a>
      </li>
      <li class="nav-item">
      <a href="{{ url('/logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
      </li>
    </ul>
    </nav>
  @endif
</div>