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
        Schema::table('book_publishers', function (Blueprint $table) {
            $table->string('published_country_tm')->default('ABŞ');
            $table->string('published_country_en')->default('USA');
            $table->string('published_country_ru')->default('USA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_publishers', function (Blueprint $table) {
            $table->dropColumn(['published_country_tm', 'published_country_en', 'published_country_ru']);
        });
    }
};
