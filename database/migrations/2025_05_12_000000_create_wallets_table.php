<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brand_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('currency')->nullable();
            $table->double('markup_amount')->nullable();
            $table->double('service_charge')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->index(['brand_id', 'name', 'type']);
            $table->index(['created_by', 'updated_by', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('brand_wallets');
    }
};