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
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vocab_group_id')->constrained('vocab_groups')->onDelete('cascade');
            $table->string('hanzi');
            $table->string('pinyin');
            $table->string('meaning');
            $table->string('example')->nullable();
            $table->string('example_pinyin')->nullable();
            $table->string('example_meaning')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabularies');
    }
};
