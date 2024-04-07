@extends('layouts.app')
@section('title','Pengaturan Profile')
@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-start w-100">
        <div class="col-lg-9 col-md-12">
            <div class="card p-3">
                <div class="card-header">
                    <div class="d-flex flex-column justify-content-center align-items-center w-100">
                        <label for="image">
                        <img src="{{asset('user.png')}}"  class="img-circle elevation-2" alt="profile">
                        </label>
                        <input class="d-none" type="file" accept="image/*" name="image" id="image">
                        <h1 class="h1 text-uppercase font-weight-bold" id="name_user">{{Auth::user()->name}}</h1>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" placeholder="name" id="name" value="{{Auth::user()->name}}" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" placeholder="username" id="username" value="{{Auth::user()->username}}"  class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" placeholder="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary" id="simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const id = $("input[name='id']");
        const name = $("input[name='name']");
        const username = $("input[name='username']");
        const password = $("input[name='password']");
        
        $("#simpan").click(function(){
           $.ajax({
            url:`{{route('settings.staff.update')}}`,
            type:'put',
            data:{id:id.val(),name:name.val(),username:username.val(),password:password.val()},
            success:function(res){
                Swal.fire({
                        position: "center",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                });
                $("#name_user").text(name.val());
                $("#user").text(name.val());
            },
            error:function(err){
                console.log(err.responJson.text);
            },
           });
        });
    });
</script>
@endsection