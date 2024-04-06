@extends('layouts.app')
@section('title','Pengaturan Web')
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center aling-items-center p-3s">
            <div class="col-sm-6">
                <div class="card w-100">
                    <div class="card-header">
                       <h6 class="font-weight-bold">Izin Akses Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 d-flex justify-content-center align-items-center">
                                <div class="container">
                                    <select name="role" id="role" class="form-control">
                                        <option selected value="-- Role --">-- Role --</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex justify-content-center align-items-center p-3">
                                <button class="btn btn-outline-primary">
                                    Atur Hak Akses
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card w-100 p-3">
                    <div class="card-header">
                        <h6 class="font-weight-bold">Setelan Aplikasi</h6>
                    </div>
                    <div class="form-group d-flex justify-content-center align-items-center p-2">
                        <img src="{{asset('icon.jpg')}}" alt="app_icon" id="app_icon"  style='width:100%;max-width:240px;aspect-ratio:1;object-fit:cover;padding:1px;border:1px solid #ddd'>
                    </div>
                    <div class="form-group">
                        <label for="app_nama" class="form-label">Nama Aplikasi</label>
                        <input type="text" name="app_name" id="app_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="app_description" class="form-label">Deskripsi</label>
                        <textarea name="app_description" id="app_description" class="form-control"></textarea>
                    </div>
                    <div class="form-group d-flex justify-content-end align-items-center">
                        <button class="btn btn-outline-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getConfig()
    {
        $.ajax({
            url:`{{route('settings.web.detail')}}`,
            success:function({config}){
                const data = JSON.parse(config);
                console.log(data.web);
                $("input[name='app_name']").val(data.web.title);
                $("#app_description").val(data.web.description);
                $("#app_icon").src=`{{asset('${data.web.icon}')}}`;
            }
        })
    }


    function getDetailRole(role){
        $.ajax({
            url:`{{route('settings.web.detail.role')}}`,
            type:'post',
            data:{role},
            success:function(response){
               console.log(response);
            }
        })
    }

    $(document).ready(function(){
        getConfig();
        getDetailRole('super_admin');
    });
</script>
@endsection
