<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonSentence extends Model
{
    use HasFactory;

    protected $table = 'common_sentences';

    protected $fillable = [
        'chinese',
        'pinyin',
        'meaning',
        'category',
    ];
}
