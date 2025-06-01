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
        Schema::create('favorite_movies', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->date('release_date')->nullable();
            $table->text('overview')->nullable();
            $table->json('genre_ids')->nullable();
            $table->integer('rating')->nullable();
            $table->string('poster_path')->nullable();
            $table->boolean(('is_favorite'))->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_movies');
    }
};
