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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('reader_id')->index();
            $table->foreign('reader_id')->references('id')->on('readers')->cascadeOnDelete();
            $table->unsignedBigInteger('book_id')->index();
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('total_price')->default(0);
            $table->dateTime('took_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->enum('reader_status', ['reading', 'completed']);
            $table->enum('book_status', ['poor', 'good']);
            $table->enum('payment_type', ['online', 'terminal', 'cash']);
            $table->boolean('cash_flowed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
