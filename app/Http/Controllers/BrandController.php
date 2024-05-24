<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\DetailBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\DeleteBrandRequest;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Illuminate\View\View;
use App\Models\Brand;

// Represetation Class Controller Brand

class BrandController extends Controller
{
    // return view page barand
    public function index(): View
    {
        return view('admin.master.barang.merk');
    }

    // return list brand in format json
    public function list(Request $request): JsonResponse
    {
        $brands = Brand::latest()->get();
        if($request -> ajax()){
            return DataTables::of($brands)
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'><i class='fas fa-pen m-1'></i>".__("edit")."</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'><i class='fas fa-trash m-1'></i>".__("delete")."</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    // save new brand
    public function save(CreateBrandRequest $request): JsonResponse
    {

        $brands = new Brand();
        $brands -> name = $request->name;
        if($request -> has('description')){
            $brands -> description = $request -> description;
        }
        $status = $brands -> save();
        if(!$status){
            return response()->json(
                ["message"=>__("failed to save")]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>__("saved successfully")
        ]) -> setStatusCode(200);
    }

    // get detail brand
    public function detail(DetailBrandRequest $request): JsonResponse
    {
        $id = $request -> id;
        $data = Brand::find($id);
        return response()->json(
            ["data"=>$data]
        )->setStatusCode(200);
    }

    // update brand
    public function update(UpdateBrandRequest $request): JsonResponse
    {
        $id = $request -> id;
        $data = Brand::find($id);
        $data -> fill($request->all());
        $status = $data -> save();
        if(!$status){
            return response()->json(
                ["message"=>__("data failed to change")]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>__("data changed successfully")
        ]) -> setStatusCode(200);
    }

    // delete brand
    public function delete(DeleteBrandRequest $request)
    {
        $id = $request -> id;
        $brands = Brand::find($id);
        $status = $brands -> delete();
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
