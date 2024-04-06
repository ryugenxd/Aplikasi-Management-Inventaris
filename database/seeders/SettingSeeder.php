<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = [
            "web"=>[
                "title"=>"Management Barang",
                "icon"=>"icon.jpg",
                "description"=>"aplikasi sistem inforamsi barang"
            ],
            "roles"=>[
                "super_admin" => [
                    "transaction" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "report" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "item" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "customer" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "supplier" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "staff" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "web" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "admin" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                ],
                "admin" =>[
                    "transaction" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "report" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "item" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "customer" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "supplier" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "staff" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "web" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "admin" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                ],
                "staff"=>[
                    "transaction" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "report" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "item" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "customer" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "supplier" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "staff" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "web" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                    "admin" => [
                        "read" => true,
                        "create" => true,
                        "update" => true,
                        "delete" => true,
                    ],
                ]
            ],
        ];
        Setting::create([
            'config'=>json_encode($config)
        ]);
    }
}
