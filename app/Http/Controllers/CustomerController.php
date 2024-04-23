<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index():View
    {
        return view('admin.master.customer');
    }

    public function list(Request $request): JsonResponse
    {
        $custormers = Customer::latest()->get();
        if($request -> ajax()){
            return DataTables::of($custormers)
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'><i class='fas fa-pen m-1'></i>".__("edit")."</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'><i class='fas fa-trash m-1'></i>".__("delete")."</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    public function save(Request $request): JsonResponse
    {
        $custormers = new Customer();
        $custormers -> name = $request->name;
        $custormers -> phone_number = $request->phone_number;
        $custormers -> address = $request->address;
        $status = $custormers -> save();
        if(!$status){
            return response()->json(
                ["message"=>"Data Gagal Di Simpan"]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>"Data Berhasil Di Simpan"
        ]) -> setStatusCode(200);
    }

    public function detail(Request $request): JsonResponse
    {
        $id = $request -> id;
        $custormer = Customer::find($id);
        return response()->json(
            ["data"=>$custormer]
        )->setStatusCode(200);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request -> id;
        $custormers = Customer::find($id);
        $custormers -> fill($request->all());
        $status = $custormers -> save();
        if(!$status){
            return response()->json(
                ["message"=>"Data Gagal Di Ubah"]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>"Data Berhasil Di Ubah"
        ]) -> setStatusCode(200);
    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request -> id;
        $custormer = Customer::find($id);
        $status = $custormer -> delete();
        if(!$status){
            return response()->json(
                ["message"=>"Data Gagal Di Hapus"]
            )->setStatusCode(400);
        }
        return response()->json([
            "message"=>"Data Berhasil Di Hapus"
        ]) -> setStatusCode(200);
    }

}
