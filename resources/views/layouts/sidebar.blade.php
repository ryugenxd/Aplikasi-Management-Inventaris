  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bg-blue elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('icon.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Menu</li>
         <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link text-white">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Master Barang
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('barang.jenis')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Jenis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('barang.satuan')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Satuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('barang.merk')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Merk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('barang')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Barang</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('customer')}}" class="nav-link text-white">
              <i class="nav-icon far fa-user"></i>
              <p>
                Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('supplier')}}" class="nav-link text-white">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>
                Supplier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link text-white">
              <i class="nav-icon fas fa-exchange-alt"></i>
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('transaksi.masuk')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('transaksi.keluar')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Keluar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link text-white">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('laporan.masuk')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Lap Barang Masuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('laporan.keluar')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Lap Barang Keluar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('laporan.stok')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Lap Stok Barang</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">LAINNYA</li>
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link text-white">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(Auth::user()->role->name != 'staff')
              <li class="nav-item">
                <a href="{{route('settings.staff')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Petugas</p>
                </a>
              </li>
            @endif
              <!-- <li class="nav-item">
                <a href="" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>web</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{route('settings.profile')}}" class="nav-link text-white">
                <i class="fas fa-angle-right"></i>
                  <p>Profile</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
              <a href="{{route('login.delete')}}" class="nav-link text-white">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Log Out
                </p>
              </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>