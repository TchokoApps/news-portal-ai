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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('language')->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('show_at_nav')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Add unique constraint for name per language
            $table->unique(['language', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
