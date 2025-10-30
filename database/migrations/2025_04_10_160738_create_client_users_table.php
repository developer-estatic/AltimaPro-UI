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
        Schema::create('client_users', function (Blueprint $table) {
             $table->id();
            $table->string('unique_id')->index();
            $table->string('platform_type')->nullable();
            $table->string('account_type')->nullable();
            $table->string('secret_data')->nullable();
            $table->string('user_role')->nullable();
            $table->uuid('account_id')->nullable();
            $table->string('currency', 10)->nullable();
            $table->integer('leverage')->nullable();
            $table->string('groupname')->nullable();
            $table->string('status')->nullable();
            $table->string('promo_code')->nullable();
            $table->string('tp_account_type')->nullable();
            $table->timestamp('lastmodifiedon')->nullable();
            $table->boolean('trading_enable')->nullable()->default(0);
            $table->string('email')->nullable();
            $table->boolean('grouptype')->nullable()->default(0);
            $table->string('bu_platform_id')->nullable();
            $table->uuid('titan_user_id')->nullable();
            $table->uuid('titan_org_id')->nullable();
            $table->string('titan_org_name')->nullable();
            $table->uuid('titan_group_id')->nullable();
            $table->string('titan_group_name')->nullable();
            $table->unsignedBigInteger('prop_tp_id')->nullable();
            $table->uuid('ark_user_id')->nullable();
            $table->string('ark_user_name')->nullable();
            $table->unsignedBigInteger('pamm_id')->nullable();
            $table->string('pamm_password')->nullable();
            $table->string('pamm_type')->nullable();
            $table->string('pamm_mm_tp')->nullable();
            $table->unsignedBigInteger('pamm_owner_id')->nullable();
            $table->text('pamm_data')->nullable();
            $table->string('swap_type')->nullable();
            $table->boolean('is_migrated')->nullable()->default(0);
            $table->boolean('is_sec_migr')->nullable()->default(0);
            $table->string('oldtpaccount')->nullable();
            $table->boolean('send_email')->nullable()->default(0);
            $table->boolean('all_close_trades')->nullable()->default(0);
            $table->boolean('all_open_trades')->nullable()->default(0);
            $table->boolean('email_sent')->nullable()->default(0);
            $table->boolean('is_deposit')->nullable()->default(0);
            $table->boolean('is_withdraw')->nullable()->default(0);
            $table->boolean('is_additional')->nullable()->default(0);
            $table->boolean('is_credit')->nullable()->default(0);
            $table->timestamps(); // includes updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_users');
    }
};
