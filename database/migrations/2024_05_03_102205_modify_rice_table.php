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
        Schema::table('rice', function (Blueprint $table) {
            // weight フィールドを nullable に変更する
            $table->float('weight')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rice', function (Blueprint $table) {
            // 変更を元に戻す
            $table->float('weight')->nullable(false)->change();
        });
    }
};
