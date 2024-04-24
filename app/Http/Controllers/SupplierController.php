<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(): View
    {
        return view('admin.master.supplier');
    }


    public function list(Request $request): JsonResponse
    {
        $suppliers = Supplier::latest()->get();
        if($request -> ajax()){
            return DataTables::of($suppliers)
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
        $suppliers = new Supplier();
        $suppliers -> name = $request->name;
        if($request->has('email')){
            $suppliers -> email = $request->email;
        }
        if($request->has("website")){
            $suppliers -> website = $request->website;
        }
        $suppliers -> phone_number = $request->phone_number;
        $suppliers -> address = $request->address;
        $status = $suppliers -> save();
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
        $custormer = Supplier::find($id);
        return response()->json(
            ["data"=>$custormer]
        )->setStatusCode(200);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request -> id;
        $suppliers = Supplier::find($id);
        $suppliers -> fill($request->all());
        $status = $suppliers -> save();
        if(!$status){
            return response()->json(
                ["message"=>__("data failed to change")]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>__("data berhasil diubah")
        ]) -> setStatusCode(200);
    }

    public function delete(Request $request): JsonResponse
    {
        $id = $request -> id;
        $custormer = Supplier::find($id);
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
