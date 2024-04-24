<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    public function index():View
    {
        return view('admin.settings.profile');
    }

    public function update(Request $request):JsonResponse
    {
        $id = $request -> id;
        $user = User::find($id);
        if(!empty($request->file('image'))){
          if(Storage::disk('local')->exists('public/profile/'.$user->image)){
           Storage::delete('public/profile/'.$user->image);
          }
          $image = $request->file('image');
          $image -> storeAs('public/profile/',$image->hashName());
          $user -> image = $image->hashName();
        }
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
}
