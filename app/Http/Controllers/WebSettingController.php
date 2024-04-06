<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Setting;

class WebSettingController extends Controller
{
    public function index(): View
    {
        $roles = Role::all();
        return view('admin.settings.web',compact('roles'));
    }


    public function detail(Request $request): JsonResponse
    {   

        $setting = Setting::get()->first();
        return response()->json($setting);
    }

    public function detailRole(Request $request): JsonResponse
    {
        $setting = (array) json_decode(Setting::first()->config);
        if($request->has('role')){
            return response()->json($setting['roles'][$request->role]);
        }
        return response()->json(['message'=>'not found'])->setStatusCode(404);
    }

    public function update(Request $request): JsonResponse
    {
        $config = Setting::get()->first();
        $setting = Setting::find($config->id);
        $setting -> config = $request -> config;
        $result = $setting -> save();
        if($result){
            return response()->json([
                'success'=>true
            ]);
        }
        return response()->json([
            'success'=>false
        ]);
    }
}
