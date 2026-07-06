<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'category',
        'event_id',
        'album_id',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
