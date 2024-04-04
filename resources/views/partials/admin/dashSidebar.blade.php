<div class="sidebar sidenav p-4 bg-dark" id="sidebar">
            <h5 class="mb-5 text-white sidebar-header	">Admin Panel</h5>
            <li>
              <a class="text-white" href="{{route('admin.dashboard')}}">
                <i class="bi bi-house mr-2"></i>
                Halaman Utama
              </a>
            </li>
            <li>
            <button class="dropdown-btn text-white"><i class="bi bi-people mr-2"></i></i> Kelola Akun
            </button>
            <div class="dropdown-container">
              <a class="text-white" href="{{route('admin.create')}}">
              <i class="bi bi-person-plus-fill"></i>
                Buat Admin Baru
              </a>
              <a class="text-white" href="{{route('admin.index')}}">
                <i class="bi bi-person-fill mr-2"></i>
                Kelola Admin
              </a>
              <a class="text-white" href="{{route('user.create')}}">
                <i class="bi bi-person-plus mr-2"></i>
                Buat Pengguna Baru
              </a>
              <a class="text-white" href="{{route('user.index')}}">
                <i class="bi bi-person mr-2"></i>
                Kelola Pengguna
              </a>
            </div>
            </li>
            <li>
            <button class="dropdown-btn text-white"><i class="bi bi-book mr-2"></i> Kelola Perpustakaan
            </button>
            <div class="dropdown-container">
              <a class="text-white" href="{{route('categories.create')}}">
                <i class="bi bi-bookshelf mr-2"></i>
                Buat Kategori Baru
              </a>
              <a class="text-white" href="{{route('categories.index')}}">
                <i class="bi bi-bookshelf mr-2"></i>
                Kelola Kategori
              </a>
              <a class="text-white" href="{{route('book.create')}}">
                <i class="bi bi-book mr-2"></i>
                Masukkan Buku Baru
              </a>
              <a class="text-white" href="{{route('book.index')}}">
                <i class="bi bi-book mr-2"></i>
                Kelola Buku
              </a>
            </div>
            </li>
            <li>
            <button class="dropdown-btn text-white"><i class="bi bi-clipboard mr-2"></i> Kelola Peminjaman
            </button>
            <div class="dropdown-container">
              <a class="text-white" href="{{route('rent.create')}}">
                <i class="bi bi-clipboard-plus mr-2"></i>
                Peminjaman Baru
              </a>
              <a class="text-white" href="{{route('rent.index')}}">
                <i class="bi bi-clipboard mr-2"></i>
                Status Peminjaman
              </a>
              <a class="text-white" href="{{route('rent.record')}}">
                <i class="bi bi-clipboard-data mr-2"></i>
                Catatan Peminjaman
              </a>
              <a class="text-white" href="{{route('rent.search')}}">
                <i class="bi bi-clipboard-check mr-2"></i>
                Pencarian Peminjaman
              </a>
            </div>
            </li>
          </div>