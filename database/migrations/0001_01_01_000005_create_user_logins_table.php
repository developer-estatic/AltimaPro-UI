<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_ip', 40)->nullable();
            $table->string('longitude', 40)->nullable();
            $table->string('latitude', 40)->nullable();
            $table->string('city', 40)->nullable();
            $table->string('country', 40)->nullable();
            $table->string('country_code', 40)->nullable();
            $table->string('browser', 40)->nullable();
            $table->string('os', 40)->nullable();
            $table->timestamps();
            $table->index(['user_id'], 'user_logins_user_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->dropIndex(['user_logins_user_id_index']);
        });
        Schema::dropIfExists('user_logins');
    }
}
