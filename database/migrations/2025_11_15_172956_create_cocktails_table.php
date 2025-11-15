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
        Schema::create('cocktails', function (Blueprint $table) {
            $table->id();
            $table->string('cocktail_id')->unique();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('alcoholic')->nullable();
            $table->string('glass')->nullable();
            $table->text('instructions')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('ingredients')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cocktails');
    }
};