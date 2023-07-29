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
        Schema::create('auth_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ip_address_id')->index();
            $table->foreign('ip_address_id')->references('id')->on('ip_addresses')->cascadeOnDelete();
            $table->unsignedBigInteger('user_agent_id')->index();
            $table->foreign('user_agent_id')->references('id')->on('user_agents')->cascadeOnDelete();
            $table->string('username');
            $table->string('event');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_attempts');
    }
};
