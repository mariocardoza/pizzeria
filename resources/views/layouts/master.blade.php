
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pizzería</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link  rel="shortcut icon"   href="{{asset('favicon.ico')}}" type="image/x-icon" />
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/font.css')}}">
  <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
</head>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <!-- Message Start -->
            <div class="media">
              <i class="fas fa-user"></i>
              <div class="media-body">
                <h3 class="dropdown-item-title">
                    <span>&nbsp;</span>Cerrar sesión
                </h3>
              </div>
            </div>
            <!-- Message End -->
          </a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
  
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4  position-fixed" style="height: 300px; overflow-y: auto;">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
      
      <span class="brand-text font-weight-light">Pizzería </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          
        </div>
        <div class="info">
          <a href="#" class="d-block">@guest Invitado @else {{Auth::user()->name}}@endguest</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2" style="overflow-y: auto;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="{{url('/home')}}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
                
              </p>
            </a>
            
          </li>
          <li class="nav-item has-treeview">
            <a href="{{url('/masas')}}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Masa/Tamaño
                
              </p>
            </a>
            
          </li>

          <li class="nav-item has-treeview">
            <a href="{{url('/ingredientes')}}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Ingredientes
                
              </p>
            </a>
            
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Pizza
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('especialidades')}}" class="nav-link reportevehiculo">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Especialidad</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('basicas')}}" class="nav-link ivapagar">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Un ingrediente</p>
                </a>
              </li>
            </ul>
          </li>
         
        </ul>

      </nav>

      <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('cabecera')<!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section id="app" class="content">
      @yield('content')
      <!-- Default box -->
      
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versión</b> 1.0
    </div>
    <strong>Copyright &copy; {{date("Y")}} <b><strong> <a href="mailto:mario.cardoza.huezo@gmail.com">Mario Cardoza</a></strong></b></strong>, Todos los derechos reservados
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('js/app.js?cod='.date('Yidisus'))}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script src="{{asset('js/datatables.min.js')}}"></script>

<!-- Bootstrap 4 -->
@yield('scripts')
</body>
</html>
