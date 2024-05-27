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
        Schema::create('emailoutbox', function (Blueprint $table) {
            $table->id();
            $table->string('sentTo');
            $table->string('sentFrom');
            $table->string('text');
            $table->datetime('sentAt');
            $table->string('deliveryStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emailoutbox');
    }
};
