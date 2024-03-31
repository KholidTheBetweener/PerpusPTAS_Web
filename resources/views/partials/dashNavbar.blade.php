<header>
<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <!-- Left navbar links -->
    <button class="btn btn-dark" id="button-toggle">
            <i class="bi bi-list"></i>
          </button>
    <a class="navbar-brand" href="#">Perpustakaan Perkantas</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if(Auth::guard('admin')->check())
                    <li class="nav-item dropdown">
                        <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                            <a href="{{route('admin.dashboard')}}" class="dropdown-item">Dashboard</a>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();">
                                Logout
                            </a>
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>        
                        </div>
                    </li>
                @endif
                
            </ul>
        </div>
  </nav>
  <!-- /.navbar -->
</header>