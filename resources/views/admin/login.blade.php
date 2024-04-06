<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{config('app.name')}} | Log in </title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('theme/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('theme/dist/css/adminlte.min.css')}}">
    <!-- sweetalert css -->
  <link rel="stylesheet" href="{{asset('theme/alert/css/sweetalert2.css')}}">
   <!-- sweetalert js-->
  <script src="{{asset('theme/alert/js/sweetalert2.js')}}"></script>
</head>
<body class="hold-transition login-page">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img  src="{{asset('loading.gif')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <div class="p-2">
          <img src="{{asset('icon.jpg')}}" alt="icon"  width="50%">
        </div>
      <a href="#" class="h1" style="text-transform:uppercase;">{{config('app.name')}}</a>
    </div>
    <div class="card-body">
      <!-- <p class="alert alert-danger mb-3 text-center font-weight-bold">username atau password salah.</p> -->
      <form action="" method="post" id="form-login">

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" id="user">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="pw">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
              Ingat Saya
              </label>
            </div>
          </div>
        </div> -->
        <div class="social-auth-links text-center mt-2 mb-3">
          <button type="submit" class="btn btn-primary btn-block font-weight-bold">Masuk</button>
        </div>
      </form>

     
      <!-- /.social-auth-links -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('theme/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('theme/dist/js/adminlte.min.js')}}"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#form-login").submit(function(e){
      e.preventDefault();
      const username = $("#user").val();
      const password = $("#pw").val();
      if(username.length == 0){
        Swal.fire({
          position: "start",
          icon: "warning",
          title:"Oops...",
          text:"Username Wajib Diisi !",
          showConfirmButton: false,
          timer: 1500
        });
      }else if(password.length == 0){
        Swal.fire({
          position: "start",
          icon: "warning",
          title:"Oops...",
          text:"Password Wajib Diisi !",
          showConfirmButton: false,
          timer: 1500
        });
      }else{
        $.ajax({
          url:"{{route('login.auth')}}",
          type:"POST",
          dataType:"JSON",
          cache:false,
          data:{
            "username":username,
            "password":password
          },
          statusCode: {
            200:function(){
              Swal.fire({
                position: "start",
                icon: "success",
                title:"Login Berhasil!",
                text:"Anda akan di arahkan ke Dashboard",
                showConfirmButton: false,
                timer: 1500,
              }).then(function(){
                window.location.href="{{route('dashboard')}}";
              });
            },
            401:function(){
              Swal.fire({
                position: "start",
                icon: "error",
                title:"Login Gagal!",
                text:"Username Atau Password Salah",
                showConfirmButton: false,
                timer: 1500
              });
            },
            500: function(xhr) {
              if(window.console) console.log(xhr.responseText);
            }
          },
          errror:function(response){
            Swal.fire({
                position: "center",
                icon: "error",
                title:"Opps!",
                text:"Server Error!",
                showConfirmButton: false,
                timer: 1500
            });
          }
        })
      }
    });
});
</script>
</body>
</html>
