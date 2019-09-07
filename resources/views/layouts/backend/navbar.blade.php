<nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="material-icons">code</i></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('petugas')}}" class="nav-link">Petugas</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('anggota')}}" class="nav-link">Anggota</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('buku')}}" class="nav-link">Buku</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('rak')}}" class="nav-link">Rak</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ url('peminjaman')}}" class="nav-link">Peminjaman</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('Pengembalian')}}" class="nav-link">Pengembalian</a>
          </li>
        </ul>
    
        <!-- SEARCH FORM -->
        {{--  <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>  --}}
      </nav>