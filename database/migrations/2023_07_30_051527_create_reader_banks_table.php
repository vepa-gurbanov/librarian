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
        Schema::create('reader_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_id')->index();
            $table->foreign('reader_id')->references('id')->on('readers')->cascadeOnDelete();
            $table->unsignedBigInteger('bank_id')->index();
            $table->foreign('bank_id')->references('id')->on('banks')->cascadeOnDelete();
            $table->unsignedFloat('electron')->default(0);
            $table->unsignedFloat('cash')->default(0);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reader_banks');
    }
};
