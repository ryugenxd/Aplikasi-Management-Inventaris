
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-flex justify-content-center align-items-center">
        <a class="nav-link h5" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center align-items-center">
        <div class="info font-weight-bold" style="text-transform:capitalize;">
            <a href="#" class="d-block" style="color:gray !important;" id="user">{{Auth::user()->name}}</a>
          </div>
          <div class="image">
            <img src="{{asset('user.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->