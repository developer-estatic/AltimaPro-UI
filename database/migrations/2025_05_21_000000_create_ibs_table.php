<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ibs', function (Blueprint $table) {
            $table->id();
            $table->string('symbol_master_name')->nullable();
            $table->unsignedBigInteger('symbol_type_id')->nullable();
            $table->unsignedBigInteger('base_spread_rate')->nullable();
            $table->unsignedBigInteger('spread_category_id')->nullable();
            $table->unsignedBigInteger('lot_value')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibs');
    }
};
