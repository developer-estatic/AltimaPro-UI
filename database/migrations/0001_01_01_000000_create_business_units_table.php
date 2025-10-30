<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name')->nullable();
            $table->boolean('status')->default(false)->nullable();
            $table->string('timezone')->default('UTC')->nullable();
            $table->string('language')->nullable();
            $table->boolean('isparent')->default(false)->nullable();
            $table->unsignedBigInteger('parent_business_unit_id')->nullable();
            $table->string('ftd_amount')->nullable();
            $table->boolean('partial_ftd')->default(false)->nullable();
            $table->string('s3_bucket_name')->nullable();
            $table->string('s3_bucket_path')->nullable();
            $table->boolean('ispamm')->default(false)->nullable();
            $table->boolean('issocial')->default(false)->nullable();
            $table->boolean('isprop')->default(false)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_units');
    }
}
