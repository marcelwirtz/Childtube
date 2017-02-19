<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['name' , 'playlist_id', 'number_of_videos', "thumbnail_path", "thumbnail_width", "thumbnail_height"];
}
