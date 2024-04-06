<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\GoodsIn;
use App\Models\Supplier;
use App\Models\Item;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class TransactionInController extends Controller
{
    public function index():View
    {
        $suppliers = Supplier::all();
        return view('admin.master.transaksi.masuk',compact('suppliers'));
    }

    public function list(Request $request):JsonResponse
    {
        $goodsins = GoodsIn::with('item','user','supplier')->latest()->get();
        if($request->ajax()){
            return DataTables::of($goodsins)
            ->addColumn('quantity',function($data){
                $item = Item::with("unit")->find($data -> item -> id);
                return $data -> quantity ."/".$item -> unit -> name;
            })
            ->addColumn("date_out",function($data){
                return Carbon::parse($data->date_received)->format('d F Y');
            })
            ->addColumn("kode_barang",function($data){
                return $data -> item -> code;
            })
            ->addColumn("supplier_name",function($data){
                return $data -> supplier -> name;
            })
            ->addColumn("item_name",function($data){
                return $data -> item -> name;
            })
            ->addColumn('tindakan',function($data){
                $button = "<button class='ubah btn btn-success m-1' id='".$data->id."'><i class='fas fa-pen m-1'></i>Ubah</button>";
                $button .= "<button class='hapus btn btn-danger m-1' id='".$data->id."'><i class='fas fa-trash m-1'></i>Hapus</button>";
                return $button;
            })
            ->rawColumns(['tindakan'])
            -> make(true);
        }
    }

    public function save(Request $request):JsonResponse
    {
        $data = [ 
            'user_id'=>$request->user_id,
            'supplier_id'=>$request->supplier_id,
            'date_received'=>$request->date_received,
            'quantity'=>$request->quantity,
            'invoice_number'=>$request->invoice_number,
            'item_id'=>$request->item_id
        ];
        GoodsIn::create($data);
        return response() -> json([
            "message"=>"Data Berhasil Di Simpan"
        ]) -> setStatusCode(200);
    }

    public function detail(Request $request):JsonResponse
    {
        $id = $request -> id;
        $data = GoodsIn::with('supplier')->where('id',$id)->first();
        $barang = Item::with('category','unit')->find($data -> item_id);
        $data['kode_barang'] = $barang -> code;
        $data['satuan_barang'] = $barang -> unit -> name;
        $data['jenis_barang'] = $barang -> category -> name;
        $data['nama_barang'] = $barang  -> name;
        $data['supplier_id'] = $data -> supplier_id;
        $data['id_barang'] = $barang -> id;
        return response()->json(
            ["data"=>$data]
        )->setStatusCode(200);
    }

    public function update(Request $request):JsonResponse
    {
        $id = $request -> id;
        $data = GoodsIn::find($id);
        $data -> user_id = $request->user_id;
        $data -> supplier_id = $request->supplier_id;
        $data -> date_received = $request->date_received;
        $data -> quantity = $request->quantity;
        $data -> item_id = $request->item_id;
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

    public function delete(Request $request):JsonResponse
    {
        $id = $request -> id;
        $data = GoodsIn::find($id);
        $status = $data -> delete();
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
