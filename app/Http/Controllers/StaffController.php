<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StaffCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class StaffController extends Controller
{
    public function index(): View
    {   $roles = Role::where('name','staff')->get();
        if(Auth::user()->role->name == 'super_admin'){
            $roles = Role::all();
        }
        return view('admin.settings.staff',compact('roles'));
    }

    public function list(Request $request): JsonResponse
    {
        $staff = User::with('role')->whereHas('role',function(Builder $builder){
            $builder = $builder -> where('name','staff');
            if(Auth::user()->role->name != 'admin'){
                $builder  ->
                orWhere('name','admin')
                -> orWhere('name','super_admin');
            }
        })->latest()->get();
        if(Auth::user()->role->name == 'staff'){
            $id_staff = Role::where('name','staff')->fisrt()->id;
            $staff = User::with('role')->where('role_id',$id_staff)->latest()->get();
        }
        if($request -> ajax()){
            return DataTables::of($staff)
            ->addColumn('role_name',function($data){
                return $data ->role-> name;
            })
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'><i class='fas fa-pen m-1'></i>".__("edit")."</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'><i class='fas fa-trash m-1'></i>".__("delete")."</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    public function save(StaffCreateRequest $request): JsonResponse
    {
        $data = $request -> validated();
        $user = new User();
        $user -> name = $data['name'];
        $user -> username = $data['username'];
        $user -> password = bcrypt($data['password']);
        $user -> role_id = $data['role_id'];
        $status = $user -> save();
        if(!$status){
            return response()->json(
                ["message"=>__("failed to save")]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>__("saved successfully")
        ]) -> setStatusCode(200);
    }

    public function detail(Request $request): JsonResponse
    {
        $id = $request -> id;
        $user = User::find($id);
        return response()->json(
            ["data"=>$user]
        )->setStatusCode(200);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request -> id;
        $user = User::find($id);
        if(!empty($request->password)){
            $user -> password = $request -> password;
        }
        if($request->has('name')){
            $user -> name = $request -> name;
        }
        if($request->has('username')){
            $user -> username = $request -> username;
        }
        $status = $user -> save();
        if(!$status){
            return response()->json(
                ["message"=>__("data failed to change")]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>__("data changed successfully")
        ]) -> setStatusCode(200);
    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request -> id;
        $user = User::find($id);
        $status = $user -> delete();
        if(!$status){
            return response()->json(
                ["message"=>__("data failed to delete")]
            )->setStatusCode(400);
        }
        return response()->json([
            "message"=>__("data deleted successfully")
        ]) -> setStatusCode(200);
    }

}
