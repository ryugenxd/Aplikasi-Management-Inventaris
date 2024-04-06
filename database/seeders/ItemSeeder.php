<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $items = [
        //     [
        //         "name"=>"Komputer",
        //         'image'=>"",
        //         'code'=>"",
        //         'price'=>"",
        //         'quantity'=>"",
        //         'category_id'=>"",
        //         'brand_id'=>"",
        //         'unit_id'=>""
        //     ]
        // ];
        // foreach($items as $item){
        //     Item::create([
        //         'name'=>$item -> name,
        //         'image'=>$item -> image,
        //         'code'=>$item -> code,
        //         'price'=>$item -> price,
        //         'quantity'=>$item -> quantity,
        //         'category_id'=>$item -> category_id,
        //         'brand_id'=>$item -> brand_id,
        //         'unit_id'=>$item -> unit_id
        //     ]);
        // }
    }
}
