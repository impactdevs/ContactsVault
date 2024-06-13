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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('conversation_id');
            $table->string('topic');
            $table->string('summary');
            $table->string('status');
            $table->string('priority');
            $table->string('queueId');
            $table->string('agentId');
            $table->DateTime('closedAt');
            $table->DateTime('createdAt');
            $table->DateTime('updatedAt');
            $table->string('pendingsince');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
