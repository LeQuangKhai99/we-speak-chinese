<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomVocabulary extends Model
{
    use HasFactory;

    protected $table = 'custom_vocabularies';

    protected $fillable = [
        'user_id',
        'hanzi',
        'pinyin',
        'meaning',
        'example',
        'example_pinyin',
        'example_meaning',
        'status',
    ];

    /**
     * Get the user that owns the custom vocabulary.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
