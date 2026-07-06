<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dj extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'biography',
        'image_path',
        'facebook_url',
        'instagram_url',
        'soundcloud_url',
        'beatport_url',
        'tiktok_url',
        'sort_order',
    ];
}
