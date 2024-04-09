<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Item;
use App\Models\GoodsIn;
use App\Models\GoodsOut;
use Yajra\DataTables\DataTables;

class ReportStockController extends Controller
{
    public function index():View
    {
        return view('admin.master.laporan.stok');
    }

    public function list(Request $request):JsonResponse
    {
        if($request->ajax()){
            if( empty($request->start_date) && empty($request->end_date)){
                $data = Item::with('goodsOuts','goodsIns');
            }else{
                $data = Item::with('goodsOuts','goodsIns');
                $data -> whereBetween('date_out',[$request->start_date,$request->end_date]);
            }
            $data -> latest() -> get();
            return DataTables::of($data)
            ->addColumn('jumlah_masuk', function ($item) {
                $totalQuantity = $item->goodsIns->sum('quantity');
                return $totalQuantity;
            })
            ->addColumn("jumlah_keluar", function ($item) {
                $totalQuantity = $item->goodsOuts->sum('quantity');
                return $totalQuantity;
            })
            ->addColumn("kode_barang", function ($item) {
                return $item->code;
            })
            ->addColumn("stok_awal", function ($item) {
                return $item->quantity;
            })
            ->addColumn("nama_barang", function ($item) {
                return $item->name;
            })
            ->addColumn("total", function ($item) {
                $totalQuantityIn = $item->goodsIns->sum('quantity');
                $totalQuantityOut = $item->goodsOuts->sum('quantity');
                $result = $item->quantity + $totalQuantityIn - $totalQuantityOut;
                $result = max(0, $result);
                if($result == 0){
                    return "<span class='text-red font-weight-bold'>".$result."</span>";
                }
                return  "<span class='text-success font-weight-bold'>".$result."</span>";
            })
            ->rawColumns(['total'])
            ->make(true);
        }
    }

    public function grafik(Request $request): JsonResponse
    {
        if($request->has('month') && !empty($request->month) ){
            $month = $request->month;
            $currentMonth = preg_split("/[-\s]/", $month)[1];
            $currentYear = preg_split("/[-\s]/", $month)[0];
        }else{
            $currentMonth = date('m');
            $currentYear = date('Y');
        }
        $goodsInThisMonth = GoodsIn::whereMonth('date_received', $currentMonth)
        ->whereYear('date_received', $currentYear)->sum('quantity');
        $goodsOutThisMonth = GoodsOut::whereMonth('date_out', $currentMonth)
        ->whereYear('date_out', $currentYear)->sum('quantity');
        $totalStockThisMonth = max(0,$goodsInThisMonth - $goodsOutThisMonth);
        return response()->json([
            'month'=>$currentYear.'-'.$currentMonth,
            'goods_in_this_month' => $goodsInThisMonth,
            'goods_out_this_month' => $goodsOutThisMonth,
            'total_stock_this_month' => $totalStockThisMonth,
        ]);
    }
}
