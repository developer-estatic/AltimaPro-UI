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
        Schema::dropIfExists('permissions');
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('model_type')->default('App\Models\User');
            $table->unsignedBigInteger('model_id')->nullable();
            $table->index(['role_id', 'model_id'], 'model_has_roles_role_id_model_id_index');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropIndex(['model_has_roles_role_id_model_id_index']);
        });
        Schema::dropIfExists('model_has_roles');
    }
};
