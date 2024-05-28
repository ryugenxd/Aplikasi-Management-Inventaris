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
  <link rel="stylesheet" href="{{ asset("localizations/flags.css") }}">
  <style>
        .lang-icon {
            background-image: url('{{ asset("localizations/flags.png") }}');
        }
  </style>
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
      <div class="navbar">
          <div class="dropdown" href="#" data-target="#lang" data-toggle="dropdown" role="button">
            <div class="d-flex gap-2 align-items-center">
              <span class="lang-icon lang-icon-{{ app()->getLocale() }}"></span>
              <span class="ml-2">ID</span>
            </div>
            <div class="dropdown-menu" id="lang">
                <ul id="lang-dropdown" class="d-flex flex-column gap-2" style="max-height: 12rem;overflow-y: scroll;"></ul>
            </div>
          </div>
        </div>
    </div>
    <div class="card-body">
      <!-- <p class="alert alert-danger mb-3 text-center font-weight-bold">username atau password salah.</p> -->
      <form action="" method="post" id="form-login">

        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" id="user">
          <div class="input-group-append">
            <div class="input-group-text" style="max-width:40px !important;">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="pw">
          <div class="input-group-append">
            <div class="input-group-text" style="max-width:40px !important;">
              <!-- nah disini w kasi id -->
              <span class="fas fa-eye" id="icon-pw"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mt-2 mb-3">
          <button type="submit" class="btn btn-primary btn-block font-weight-bold">{{ __("messages.login") }}</button>
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
  function changeLanguage(lang) {
    let url = new URL(window.location.href);

    url.searchParams.set("lang", lang);
    window.location.href = url.toString();
  }
  $(document).ready(async () => {
    let languages = await (await fetch("{{ url(asset('localizations/languages.json')) }}")).json();
    for (let code in languages) {
      let native = languages[code].nameNative;
      let english = languages[code].nameEnglish;

      $("#lang-dropdown").append(`
        <li onclick="changeLanguage('${ code }')" class="d-flex align-items-center justify-content-start gap-2 px-2">
          <div class="lang-icon lang-icon-${ code }"></div>
          <span class="ml-2 text-uppercase" style="font-size: .8rem" data-text="${ english }">${ code }</span>
        </li>
      `);
    }
  });
</script>
<script>
$(document).ready(function(){
    $("#form-login").submit(function(e){
      e.preventDefault();
      const username = $("#user").val();
      const password = $("#pw").val();
      if(username.length == 0){
        Swal.fire({
          position: "start",
          icon: "warning",
          title:"{{ __("messages.oops") }}",
          text:"{{ __('validation.required', ['attribute' => 'username']) }}",
          showConfirmButton: false,
          timer: 1500
        });
      }else if(password.length == 0){
        Swal.fire({
          position: "start",
          icon: "warning",
          title:"{{ __("messages.oops") }}",
          text:"{{ __('validation.required', ['attribute' => 'password']) }}",
          showConfirmButton: false,
          timer: 1500
        });
      }else{
        $.ajax({
          url:"{{route('login.auth')}}",
          type:"POST",
          dataType:"JSON",
          cache:false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:{
            "username":username,
            "password":password
          },
          statusCode: {
            200:function(){
              Swal.fire({
                position: "start",
                icon: "success",
                title:"{{ __('auth.success') }}",
                text:"{{ __('messages.redirect-to', ['dest' => 'dashboard']) }}",
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
                title:"{{ __('auth.failed') }}!",
                text:"{{ __('auth.failed-message') }}",
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
                title:"{{ __('messages.oops') }}",
                text:"{{ __('messages.server-error') }}",
                showConfirmButton: false,
                timer: 1500
            });
          }
        })
      }
    });
});
</script>
<!-- yahhooo heheheh -->
<script>
  $(document).ready(function() {
    // okeh iya yoshaaaaaaa horeeee omagaaaa
    // gimana ? coba run
    // malah icon slash nya cok, pas diklik ,iya omagaaa  coba kirim di wa  okeh owlah ga bisa balik ke icon eye ?
    $("#icon-pw").click(function() {
      if($(this).attr("class") == "fas fa-eye"){
        $(this).addClass("fa-eye-slash");
        $(this).removeClass("fa-eye");
      }else{
        $(this).removeClass("fa-eye-slash");
        $(this).addClass("fa-eye");
      }
      var input = $("#pw");
      input.attr("type") === "password" ? input.attr("type", "text") : input.attr("type", "password");
    });
  });
</script>
</body>
</html>
