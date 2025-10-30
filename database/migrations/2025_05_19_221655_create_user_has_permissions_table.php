<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('user_has_permissions');
        Schema::create('user_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->enum('permission_type', ['menu', 'action'])->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->index(['brand_id', 'user_id'], 'user_has_permissions_brand_id_user_id_index');
            $table->index(['permission_id', 'permission_type'], 'user_has_permissions_permission_id_permission_type_index');
            $table->index(['created_by', 'updated_by'], 'user_has_permissions_created_by_updated_by_index');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_has_permissions', function (Blueprint $table) {
            $table->dropIndex(['user_has_permissions_brand_id_user_id_index']);
            $table->dropIndex(['user_has_permissions_permission_id_permission_type_index']);
            $table->dropIndex(['user_has_permissions_created_by_updated_by_index']);
        });
        Schema::dropIfExists('user_has_permissions');
    }
};
