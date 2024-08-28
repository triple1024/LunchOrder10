<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('t_stocks', function (Blueprint $table) {
            $table->integer('sort_order')->nullable()->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('t_stocks', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
