<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;


    protected $fillable = [
        'summary',
        'description',
        'status',
        'property_id',
        'user_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
