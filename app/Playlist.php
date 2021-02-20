<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Playlist extends Model
{
    protected $fillable = ['name' , 'playlist_id_yt', "thumbnail_path", "thumbnail_width", "thumbnail_height"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos() : HasMany
    {
        return $this->hasMany(Video::class)->orderBy("sort", "ASC");
    }
}
