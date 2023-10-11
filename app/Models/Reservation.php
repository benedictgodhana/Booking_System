<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['guest_name', 'user_id', 'room_id', 'reservationDate', 'reservationTime', 'status', 'timelimit', 'item_id', 'guest_email', 'guest_department', 'event'];




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a many-to-one relationship with the Item model.
        */
        public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function acceptedByUser()
    {
        return $this->belongsTo(User::class, 'accepted_by_user_id');
    }

    public function declinedByUser()
    {
        return $this->belongsTo(User::class, 'declined_by_user_id');
    }
}
