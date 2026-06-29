<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLecture extends Model
{
    use HasFactory;

    protected $table = 'video_lectures';

    protected $fillable = [
        'title',
        'youtube_id',
        'thumbnail_url',
        'category',
        'level',
        'video_count',
    ];
}
