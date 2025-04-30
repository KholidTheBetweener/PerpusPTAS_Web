<!DOCTYPE html>
<html>
    <head>  
        <title>Perpustakaan Perkantas</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @include('partials.dashHead')
    </head>
    <style>
li {
        list-style: none;
        margin: 15px 0 15px 0;
    }

    a {
        text-decoration: none;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        margin-left: -300px;
        transition: 0.4s;
    }

    .active-main-content {
        margin-left: 250px;
    }

    .active-sidebar {
        margin-left: 0;
    }

    #main-content {
        transition: 0.4s;
    }
/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 15px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width:100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 250px; /* Same as the width of the sidenav */
  font-size: 15px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: dark;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 8px;
}
.tab-content .tab-pane {
  background-color: #FFF;
  color: #000;
  min-height: 200px;
  height: auto;
}
</style>
    <body>
        <div class="wrapper">
<header>
<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <!-- Left navbar links -->
    <a class="navbar-brand navbar-nav ms-auto" href="#"><img src="https://researcheve.com/public/assets/images/perkantas.png" width="250" height="50"></a>
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
            @if(Auth::check()) 
            <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="{{ route('userprofile') }}" role="button">
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('home') }}" role="button">
                                    Buku Perpustakaan
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link" href="{{ route('notifications') }}" role="button">
                                    Notifikasi
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ route('rent') }}" role="button">
                                    Riwayat Peminjaman
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();">
                                Logout
                            </a>
                            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>        
                            </li>
            </ul>
            @else
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                        <a href="{{route('welcome')}}" class="nav-link" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Home <span class="caret"></span>
                        </a>
                    </li>  
                    <li class="nav-item">
                    <a href="{{route('profile')}}" class="nav-link" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Profile <span class="caret"></span>
                        </a>
                    </li>   
                    <li class="nav-item">
                    <a href="{{route('about')}}" class="nav-link" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            About <span class="caret"></span>
                        </a>
                    </li>   
                    <li class="nav-item">
                    <a href="{{route('contact')}}" class="nav-link" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Contact <span class="caret"></span>
                        </a>
                    </li>   
                    <li class="nav-item">
                    <a href="{{route('download')}}" class="nav-link" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                            Download <span class="caret"></span>
                        </a>
                    </li>
            </ul>
            @endif
        </div>
  </nav>
  <!-- /.navbar -->
</header>
            
            <div class="content-wrapper">
                <!-- This Line is For Breadcrumb -->
                <!-- Main content -->
                <section class="content" id="main-content">
                    @yield('content')
                </section>
                <!-- End of Main content -->
            </div>
            <!-- @include('partials.dashFooter') -->
        </div>
        <script>
    // event will be executed when the toggle-button is clicked
    document.getElementById("button-toggle").addEventListener("click", () => {

        // when the button-toggle is clicked, it will add/remove the active-sidebar class
        document.getElementById("sidebar").classList.toggle("active-sidebar");

        // when the button-toggle is clicked, it will add/remove the active-main-content class
        document.getElementById("main-content").classList.toggle("active-main-content");
    });
</script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
    </body>
</html>
