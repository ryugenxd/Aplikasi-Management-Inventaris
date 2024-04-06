<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('goods_out', function (Blueprint $table) {
            $table -> unsignedBigInteger('customer_id');
            $table -> foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goods_out', function (Blueprint $table) {
            $table -> dropColumn('customer_id');
        });
    }
};
