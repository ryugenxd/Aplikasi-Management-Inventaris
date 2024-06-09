<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Models\Customer;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerController extends Controller
{
    public function index():View
    {
        return view('admin.master.customer');
    }

    public function list(Request $request): JsonResponse
    {
        $customers = Customer::latest()->get();
        if($request -> ajax()){
            return DataTables::of($customers)
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'><i class='fas fa-pen m-1'></i>".__("edit")."</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'><i class='fas fa-trash m-1'></i>".__("delete")."</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    public function save(CreateCustomerRequest $request): JsonResponse
    {
        $customers = new Customer();
        $customers -> name = $request->name;
        $customers -> phone_number = $request->phone_number;
        $customers -> address = $request->address;
        $status = $customers -> save();
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
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        $custormer = Customer::find($validated['id']);
        if(!$custormer) throw new HttpResponseException(response([
            "message"=>"not found."
        ],404));
        return response()->json(
            ["data"=>$custormer]
        )->setStatusCode(200);
    }

    public function update(UpdateCustomerRequest $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        $custormer = Customer::find($validated['id']);
        if(!$custormer) throw new HttpResponseException(response([
            "message"=>"not found."
        ],404));
        $custormer -> fill($request->all());
        $status = $custormer -> save();
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
        if(!$custormer) throw new HttpResponseException(response([
            "message"=>"not found."
        ],404));
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
