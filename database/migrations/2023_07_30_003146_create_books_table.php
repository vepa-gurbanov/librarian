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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reader_id')->index()->nullable();
            $table->foreign('reader_id')->references('id')->on('readers')->nullOnDelete();
            $table->json('name');
            $table->json('full_name')->nullable();
            $table->string('slug')->unique();
            $table->string('barcode')->unique();
            $table->string('book_code');
            $table->json('body')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('page')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('value')->default(0);
            $table->unsignedInteger('liked')->default(0);
            $table->unsignedInteger('viewed')->default(0);
            $table->date('written_at');
            $table->date('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
