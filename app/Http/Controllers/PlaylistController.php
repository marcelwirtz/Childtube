<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use App\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("playlist.index")->with("playlists", Playlist::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('playlist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yt_playlist = Youtube::getPlaylistById($request->playlist_id);
        if($yt_playlist) {
            $playlistItems = Youtube::getPlaylistItemsByPlaylistId($request->playlist_id);
            $playlist = new Playlist(array(
                'name' => $yt_playlist->snippet->title,
                'playlist_id' => $request->playlist_id,
                'number_of_videos' => $playlistItems['info']['totalResults'],
                'thumbnail_path' => $yt_playlist->snippet->thumbnails->standard->url,
                'thumbnail_width' => $yt_playlist->snippet->thumbnails->standard->width,
                'thumbnail_height' => $yt_playlist->snippet->thumbnails->standard->height,
            ));
            $playlist->save();
            $request->session()->flash('status', 'Erfolgreich gespeichert!');
        } else {
            $request->session()->flash('error', 'Keine gültige Playlist');
        }
        return redirect()->route("playlist.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist, $pageToken = "")
    {
        $playlistItems = Youtube::getPlaylistItemsByPlaylistId($playlist->playlist_id, $pageToken);
        return view("playlist.show")->with(array(
            "playlist" => $playlist,
            "videos" => $playlistItems['results'],
            "prevPageToken" => $playlistItems['info']['prevPageToken'],
            "nextPageToken" => $playlistItems['info']['nextPageToken']

        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route("playlist.index");
    }
}
