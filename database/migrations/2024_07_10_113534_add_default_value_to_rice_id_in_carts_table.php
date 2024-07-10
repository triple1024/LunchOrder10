<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // rice_id カラムにデフォルト値を設定
            $table->unsignedBigInteger('rice_id')->default(1)->change();
        });
    }


    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // デフォルト値を解除
            $table->unsignedBigInteger('rice_id')->default(null)->change();
        });
    }
};
