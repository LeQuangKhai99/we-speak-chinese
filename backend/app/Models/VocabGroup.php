<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VocabGroup extends Model
{
    use HasFactory;

    protected $fillable = ['vocab_set_id', 'index', 'name', 'desc'];

    /**
     * Get the set that owns the group.
     */
    public function set(): BelongsTo
    {
        return $this->belongsTo(VocabSet::class, 'vocab_set_id');
    }

    /**
     * Get the vocabularies in this group.
     */
    public function vocabularies(): HasMany
    {
        return $this->hasMany(Vocabulary::class);
    }
}
