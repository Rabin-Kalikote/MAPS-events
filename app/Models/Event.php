<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'location_x',
        'location_y',
        'date',
        'status',
    ];
}
