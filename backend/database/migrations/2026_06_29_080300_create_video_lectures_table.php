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
        Schema::create('video_lectures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_id');
            $table->string('thumbnail_url');
            $table->string('category'); // 'Tổng hợp', 'Từ vựng', 'Ngữ pháp', 'Luyện nghe', 'Luyện nói'
            $table->string('level'); // 'Sơ cấp', 'Trung cấp', 'Cao cấp'
            $table->integer('video_count')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_lectures');
    }
};
