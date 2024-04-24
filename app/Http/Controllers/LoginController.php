<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('admin.login');
    }


    public function auth(Request $request):JsonResponse
    {
        $username = $request -> username;
        $password = $request -> password;
        if(!Auth::guard('web')->attempt(['username'=>$username,'password'=>$password])){
            return response()->json([
                "success"=>false,
                "message"=>__("incorrect username or password")." !"
            ])
            ->setStatusCode(401);
        }
        return response()->json([
            "route"=>route('dashboard'),
            "success"=>true,
            "message"=>__("login successful")." !"
        ])
        ->setStatusCode(200);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
