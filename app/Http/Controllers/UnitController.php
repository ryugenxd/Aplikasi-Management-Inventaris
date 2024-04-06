<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Illuminate\View\View;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index(): View
    {
        return view('admin.master.barang.satuan');
    }

    public function list(Request $request): JsonResponse
    {
        $units = Unit::latest()->get();
        if($request -> ajax()){
            return DataTables::of($units)
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'>Ubah</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'>Hapus</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    public function save(Request $request): JsonResponse
    {

        $units = new Unit();
        $units -> name = $request->name;
        if($request -> has('description')){
            $units -> description = $request -> description;
        }
        $status = $units -> save();
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
        $data = Unit::find($id);
        return response()->json(
            ["data"=>$data]
        )->setStatusCode(200);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request -> id;
        $data = Unit::find($id);
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

    public function delete(Request $request)
    {
        $id = $request -> id;
        $units = Unit::find($id);
        $status = $units -> delete();
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
