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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('msg_id');
            $table->string('channel');
            $table->string('from');
            $table->string('to');
            $table->string('direction');
            $table->string('conversationId');
            $table->string('text');
            $table->DateTime('closedAt');
            $table->DateTime('createdAt');
            $table->DateTime('updatedAt');
            $table->string('contentType');
            $table->timestamps();
        });
    }

        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
