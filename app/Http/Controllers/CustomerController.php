<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerCreateRequest;
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

    public function save(CustomerCreateRequest $request): JsonResponse
    {
        $data = $request -> validated();
        $custormers = new Customer();
        $custormers -> name = $data['name'];
        $custormers -> phone_number = $data['phone_number'];
        $custormers -> address = $data['address'];
        $status = $custormers -> save();
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
        $custormer = Customer::find($id);
        $status = $custormer -> delete();
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
