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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_logo_path')->nullable();
            $table->string('company_phone_number')->nullable();
            $table->string('company_email')->nullable();
            $table->string('fb_messenger_username')->nullable();
            $table->string('twitter_username')->nullable();
            $table->string('lapse_time')->nullable();
            $table->string('followup_time')->nullable();
            $table->string('automatic_reply_on_first_received_message')->nullable();
            $table->string('is_automatic_reply_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
