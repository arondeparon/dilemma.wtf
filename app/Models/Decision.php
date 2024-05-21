<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Decision extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id'];

    public function firstDilemma(): BelongsTo
    {
        return $this->belongsTo(Dilemma::class, 'first_dilemma_id');
    }

    public function secondDilemma(): BelongsTo
    {
        return $this->belongsTo(Dilemma::class, 'second_dilemma_id');
    }

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
