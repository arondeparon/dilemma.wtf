<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dilemma extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(Decision::class);
    }
}
