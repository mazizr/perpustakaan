<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><i class="fa-book"></i></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Perpustakaan</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    </nav>
  </header>

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Data Master</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{ url('petugas')}}"><i class="fa fa-circle-o"></i> Petugas</a></li>
                  <li><a href="{{ url('anggota')}}"><i class="fa fa-circle-o"></i> Anggota</a></li>
                  <li><a href="{{ url('buku')}}"><i class="fa fa-circle-o"></i> Buku</a></li>
                  <li><a href="{{ url('rak')}}"><i class="fa fa-circle-o"></i> Rak</a></li>
                </ul>
              </li>
            <li class="treeview">
              <a href="#">
                  <i class="fa fa-edit"></i> <span>Transaksi</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('peminjaman')}}"><i class="fa fa-circle-o"></i> Peminjaman</a></li>
                <li><a href="{{ url('pengembalian')}}"><i class="fa fa-circle-o"></i> Pengembalian</a></li>
                </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>