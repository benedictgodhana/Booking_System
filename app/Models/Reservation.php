<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a many-to-one relationship with the Item model.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
