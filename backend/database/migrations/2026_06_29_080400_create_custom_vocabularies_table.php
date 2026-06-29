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
        Schema::create('custom_vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('hanzi');
            $table->string('pinyin');
            $table->string('meaning');
            $table->string('example')->nullable();
            $table->string('example_pinyin')->nullable();
            $table->string('example_meaning')->nullable();
            $table->string('status')->default('learning'); // 'learning', 'learned'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_vocabularies');
    }
};
