<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image_path',
        'event_id',
        'is_active',
    ];

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
