<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DetailCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.master.barang.jenis');
    }

    public function list(Request $request): JsonResponse
    {
        $category = Category::latest()->get();
        if($request -> ajax()){
            return DataTables::of($category)
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'>Ubah</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'>Hapus</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    public function save(CreateCategoryRequest $request): JsonResponse
    {

        $category = new Category();
        $category -> name = $request->name;
        if($request -> has('description')){
            $category -> description = $request -> description;
        }
        $status = $category -> save();
        if(!$status){
            return response()->json(
                ["message"=>"Data Gagal Di Simpan"]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>"Data Berhasil Di Simpan"
        ]) -> setStatusCode(200);
    }

    public function detail(DetailCategoryRequest $request): JsonResponse
    {  
        $id = $request -> id;
        $data = Category::find($id);
        return response()->json(
            ["data"=>$data]
        )->setStatusCode(200);
    }

    public function update(UpdateCategoryRequest $request): JsonResponse
    {
        $id = $request -> id;
        $data = Category::find($id);
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

    public function delete(DeleteCategoryRequest $request)
    {
        $id = $request -> id;
        $category = Category::find($id);
        $status = $category -> delete();
        if(!$status){
            return response()->json(
                ["message"=>"Data Gagal Di Hapus"]
            )->setStatusCode(400);
        }
        return response() -> json([
            "message"=>"Data Berhasil Di Hapus"
        ]) -> setStatusCode(200);
    }

}
