<?php

namespace App\Traits\Relationship;

use App\Models\Status;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait StatusRelationTrait
{
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function visibility(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'visibility_id', 'id');
    }
}
