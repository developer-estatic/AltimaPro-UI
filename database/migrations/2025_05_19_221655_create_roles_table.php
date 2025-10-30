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
        Schema::dropIfExists('roles');
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('guard_name')->nullable()->default('web');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->index(['name', 'parent_id', 'created_by', 'updated_by'], 'roles_name_parent_id_created_by_updated_by_index');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['roles_name_parent_id_created_by_updated_by_index']);
        });
        Schema::dropIfExists('roles');
    }
};
