<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\GoodsOut;
use App\Models\Customer;
use App\Models\Item;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class TransactionOutController extends Controller
{
    public function index():View
    {
        $customers = Customer::all();
        return view('admin.master.transaksi.keluar',compact('customers'));
    }

    public function list(Request $request):JsonResponse
    {
        $goodsouts = GoodsOut::with('item','user','customer')->latest()->get();
        if($request->ajax()){
            return DataTables::of($goodsouts)
            ->addColumn('quantity',function($data){
                $item = Item::with("unit")->find($data -> item -> id);
                return $data -> quantity ."/".$item -> unit -> name;
            })
            ->addColumn("date_received",function($data){
                return Carbon::parse($data->date_received)->format('d F Y');
            })
            ->addColumn("kode_barang",function($data){
                return $data -> item -> code;
            })
            ->addColumn("customer_name",function($data){
                return $data -> customer -> name;
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
            'item_id'=>$request->item_id,
            'user_id'=>$request->user_id,
            'quantity'=>$request->quantity,
            'invoice_number'=>$request->invoice_number,
            'date_out'=>$request->date_out,
            'customer_id'=>$request->customer_id
        ];
        GoodsOut::create($data);
        return response() -> json([
            "message"=>"Data Berhasil Di Simpan"
        ]) -> setStatusCode(200);
    }

    public function detail(Request $request):JsonResponse
    {
        $id = $request -> id;
        $data = GoodsOut::with('Customer')->where('id',$id)->first();
        $barang = Item::with('category','unit')->find($data -> item_id);
        $data['kode_barang'] = $barang -> code;
        $data['satuan_barang'] = $barang -> unit -> name;
        $data['jenis_barang'] = $barang -> category -> name;
        $data['nama_barang'] = $barang  -> name;
        $data['customer_id'] = $data -> customer_id;
        $data['id_barang'] = $barang -> id;
        return response()->json(
            ["data"=>$data]
        )->setStatusCode(200);
    }

    public function update(Request $request):JsonResponse
    {
        $id = $request -> id;
        $data = GoodsOut::find($id);
        $data -> user_id = $request->user_id;
        $data -> customer_id = $request->customer_id;
        $data -> date_out = $request->date_out;
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
        $data = GoodsOut::find($id);
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
