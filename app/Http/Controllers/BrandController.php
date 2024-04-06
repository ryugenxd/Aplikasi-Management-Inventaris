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

class BrandController extends Controller
{
    public function index(): View
    {
        return view('admin.master.barang.merk');
    }
    
    public function list(Request $request): JsonResponse
    {
        $brands = Brand::latest()->get();
        if($request -> ajax()){
            return DataTables::of($brands)
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'>Ubah</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'>Hapus</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

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
                ["message"=>"Data Gagal Di Simpan"]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>"Data Berhasil Di Simpan"
        ]) -> setStatusCode(200);
    }

    public function detail(DetailBrandRequest $request): JsonResponse
    {  
        $id = $request -> id;
        $data = Brand::find($id);
        return response()->json(
            ["data"=>$data]
        )->setStatusCode(200);
    }

    public function update(UpdateBrandRequest $request): JsonResponse
    {
        $id = $request -> id;
        $data = Brand::find($id);
        $data -> fill($request->all());
        $status = $data -> save();
        if(!$status){
            return response()->json(
                ["message"=>"Data Gagal Di Ubah"]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>"Data Berhasil Di Ubah"
        ]) -> setStatusCode(200);
    }

    public function delete(DeleteBrandRequest $request)
    {
        $id = $request -> id;
        $brands = Brand::find($id);
        $status = $brands -> delete();
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
