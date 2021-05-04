<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'playlist_id', 'video_id', 'thumbnail_path', 'thumbnail_width', 'thumbnail_height', 'channel_id', 'channel_title', 'sort'];
}
