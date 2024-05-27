<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    public function up()
    {
        Schema::create('outbox', function (Blueprint $table) {
            $table->id();
            $table->string('sentTo');
            $table->string('sentFrom');
            
            $table->text('body');
            $table->string('channel');
            $table->string('deliveryStatus');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbox');
    }
};
