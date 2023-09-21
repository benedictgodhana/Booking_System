<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
    ];

    // Define any relationships here, for example:
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming there's a "users" table
    }
}
