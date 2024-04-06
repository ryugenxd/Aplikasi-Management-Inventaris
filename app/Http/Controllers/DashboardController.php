<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Item;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Role;
use App\Models\User;
use App\Models\GoodsIn;
use App\Models\GoodsOut;
use App\Models\Customer;


class DashboardController extends Controller
{
    public function index(): View
    {

        $product_count = Item::count();
        $category_count = Category::count();
        $unit_count = Unit::count();
        $brand_count = Brand::count();
        $goodsin = GoodsIn::count();
        $goodsout = GoodsOut::count();
        $customer = Customer::count();
        $supplier = Supplier::count();
        $staffCount = User::where('role_id',2)->count();
        return view('admin.dashboard',compact('product_count',
        'category_count','unit_count',
        'brand_count','goodsin','goodsout','customer','supplier','staffCount'));
    }
}
