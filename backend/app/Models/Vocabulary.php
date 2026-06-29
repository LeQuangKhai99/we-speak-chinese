<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'vocab_group_id',
        'hanzi',
        'pinyin',
        'meaning',
        'example',
        'example_pinyin',
        'example_meaning'
    ];

    /**
     * Get the group that owns the vocabulary.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(VocabGroup::class, 'vocab_group_id');
    }

    /**
     * Get the user progress records for this vocabulary.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }
}
