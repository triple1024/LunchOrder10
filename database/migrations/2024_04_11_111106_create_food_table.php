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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('owner_id')->constrained()
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
            $table->string('name');
            $table->foreignId('image')->constrained()
                ->nullable()
                ->constrained('images');
            $table->boolean('is_selling');
            $table->integer('sort_order');
            $table->foreignId('secondary_category_id')->constrained();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
