<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VocabSet extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'title', 'subtitle', 'color'];

    /**
     * Get the groups for the vocabulary set.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(VocabGroup::class);
    }
}
