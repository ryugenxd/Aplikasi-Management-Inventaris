<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_login_success(): void
    {
        $role = Role::where('name','super_admin')->get()->first();
        $user_test = [
            "name"=>"test",
            "username" => "user_test",
            "password" => bcrypt("12345678") ,
            "role_id" =>  $role -> id
        ];
        User::create($user_test);
        $this -> post('/',[
            'username'=>$user_test["username"],
            'password'=>'12345678'
        ])->assertStatus(200)
        ->assertJson([
            "success"=>true,
            "message"=>"Login Berhasil !"
        ]);
    }

    public function test_login_failed():void
    {
        $role = Role::where('name','super_admin')->get()->first();
        $user_test = [
            "name"=>"test",
            "username" => "user_test",
            "password" => bcrypt("12345678") ,
            "role_id" =>  $role -> id
        ];

        User::create($user_test);
        $this -> post('/',[
            'username'=>$user_test["username"],
            'password'=>'345446464'
        ])->assertStatus(401)
        ->assertJson([
            "success"=>false,
            "message"=>"Username Atau Password Salah !"
        ]);
    }
}
