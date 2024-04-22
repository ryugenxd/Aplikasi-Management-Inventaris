<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\GoodsIn;
use App\Models\GoodsOut;

class ReportFinancialController extends Controller
{
    public function income(Request $request): JsonResponse
    {
        if($request->has('month') && !empty($request->month) ){
            $month = $request->month;
            $currentMonth = preg_split("/[-\s]/", $month)[1];
            $currentYear = preg_split("/[-\s]/", $month)[0];
        }else{
            $currentMonth = date('m');
            $currentYear = date('Y');
        }
        $totalIncomeMasukan = GoodsIn::whereMonth('date_received',$currentMonth)->whereYear('date_received', $currentYear)
        ->with('item')
        ->get()
        ->sum(function ($goodsIn) {
            $price = intval(preg_replace("/[^0-9]/", "", $goodsIn->item->price));
            return $price * $goodsIn -> quantity;
        });

        $totalIncomePengeluaran = GoodsOut::whereMonth('date_out', $currentMonth)
        ->whereYear('date_out', $currentYear)->with('item')->get()->sum(function ($goodsOut) {
            $price = intval(preg_replace("/[^0-9]/", "", $goodsOut->item->price));
            return $price * $goodsOut->quantity;
        });

        $totalIncome =  max(0,floor($totalIncomePengeluaran - $totalIncomeMasukan));
        // dd($totalIncome);
        return response() -> json([
            'bulan'=>$currentYear.'-'.$currentMonth,
            "pendapatan" => $totalIncomeMasukan,
            "pengeluaran" => $totalIncomePengeluaran,
            "total" => $totalIncome
        ]);
    }
}
