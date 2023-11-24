<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('dash/plugins/fontawesome-free/css/all.min.css') }}">
<link
          rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
          integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK"
          crossorigin="anonymous"
        />
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
        />
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ asset('dash/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('dash/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('dash/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dash/dist/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('dash/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('dash/plugins/daterangepicker/daterangepicker.css') }}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<!-- Javascript -->
<!-- CKEditor -->
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('dash/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('dash/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dash/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('dash/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('dash/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('dash/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('dash/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('dash/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('dash/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('dash/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('dash/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('dash/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dash/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dash/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dash/dist/js/demo.js') }}"></script>
<script src="/build/constrast-bootstrap-pro/js/cdb.js"></script>
<script>
  const sidebar = document.querySelector('.sidebar');
  new CDB.Sidebar(sidebar);
</script>
<script src="https://www.gstatic.com/firebasejs/10.3.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.3.0/firebase-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// Initialize Firebase
var firebaseConfig = {
  apiKey: "AIzaSyAWmIRQ2eMGp1lHBqRcPOqYc4tz6lMhk_k",
  authDomain: "website-perkantas.firebaseapp.com",
  databaseURL: "https://website-perkantas-default-rtdb.firebaseio.com",
  projectId: "website-perkantas",
  storageBucket: "website-perkantas.appspot.com",
  messagingSenderId: "908742285752",
  appId: "1:908742285752:web:f6a5bf474976b497d7574d",
  measurementId: "G-EV236HR4VF"
};
firebase.initializeApp(config);

</script>

