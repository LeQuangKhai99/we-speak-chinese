<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HskListeningTest extends Model
{
    use HasFactory;

    protected $table = 'hsk_listening_tests';

    protected $fillable = [
        'image_path',
        'audio_text',
        'correct_option',
        'option_a',
        'option_a_meaning',
        'option_b',
        'option_b_meaning',
        'option_c',
        'option_c_meaning',
        'option_d',
        'option_d_meaning',
    ];
}
