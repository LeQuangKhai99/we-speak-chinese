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
        Schema::create('hsk_listening_tests', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('audio_text');
            $table->string('correct_option'); // 'A', 'B', 'C', 'D'
            $table->string('option_a');
            $table->string('option_a_meaning');
            $table->string('option_b');
            $table->string('option_b_meaning');
            $table->string('option_c');
            $table->string('option_c_meaning');
            $table->string('option_d');
            $table->string('option_d_meaning');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hsk_listening_tests');
    }
};
