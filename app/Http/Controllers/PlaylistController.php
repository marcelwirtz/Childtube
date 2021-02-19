<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use App\Playlist;
use App\Video;
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $playlist = new Playlist(array(
            'name' => $request->name,
            'playlist_id_yt' => $request->playlist_id_yt,
            'thumbnail_path' => $request->thumbnail_path,
            'thumbnail_width' => $request->thumbnail_width,
            'thumbnail_height' => $request->thumbnail_height
        ));
        $playlist->save();

        if(!empty($request->playlist_id_yt)) {
            $yt_playlist = Youtube::getPlaylistById($request->playlist_id_yt);
            if ($yt_playlist) {
                $playlistItems = Youtube::getPlaylistItemsByPlaylistId($request->playlist_id_yt);

                $playlist->name = $yt_playlist->snippet->title;
                $playlist->thumbnail_path = isset($yt_playlist->snippet->thumbnails->standard->url) ? $yt_playlist->snippet->thumbnails->standard->url : $yt_playlist->snippet->thumbnails->default->url;
                $playlist->thumbnail_width = isset($yt_playlist->snippet->thumbnails->standard->width) ? $yt_playlist->snippet->thumbnails->standard->width : $yt_playlist->snippet->thumbnails->default->width;
                $playlist->thumbnail_height = isset($yt_playlist->snippet->thumbnails->standard->height) ? $yt_playlist->snippet->thumbnails->standard->height : $yt_playlist->snippet->thumbnails->default->height;
                $playlist->save();

                foreach($playlistItems['results'] as $key => $item) {
                    $video = new Video([
                        'playlist_id' => $playlist->id,
                        'video_id' => $item->snippet->resourceId->videoId,
                        'title' => $item->snippet->title,
                        'thumbnail_path' => isset($item->snippet->thumbnails->standard->url) ? $item->snippet->thumbnails->standard->url : $item->snippet->thumbnails->default->url,
                        'thumbnail_width' => isset($item->snippet->thumbnails->standard->width) ? $item->snippet->thumbnails->standard->width : $item->snippet->thumbnails->default->width,
                        'thumbnail_height' => isset($item->snippet->thumbnails->standard->height) ? $item->snippet->thumbnails->standard->height : $item->snippet->thumbnails->default->height,
                        'channel_id' => $item->snippet->videoOwnerChannelId,
                        'channel_title' => $item->snippet->videoOwnerChannelTitle,
                        'sort' => $key
                    ]);
                    $video->save();
                }
            }
        }

        $request->session()->flash('status', 'Erfolgreich gespeichert!');
        return redirect()->route("playlist.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        return view("playlist.show")->with([
            "playlist" => $playlist,
            "videos" => $playlist->videos()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        return view('playlist.edit')->with([ "playlist" => $playlist ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $playlist->name = $request->name;
        $playlist->playlist_id_yt = $request->playlist_id_yt;
        $playlist->thumbnail_path = $request->thumbnail_path;
        $playlist->thumbnail_width = $request->thumbnail_width;
        $playlist->thumbnail_height = $request->thumbnail_height;

        $playlist->save();
        $request->session()->flash('status', 'Erfolgreich gespeichert!');
        return redirect()->route("playlist.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route("playlist.index");
    }

    public function videos(Request $request, Playlist $playlist) {
        $videos = null;
        if($request->has('q')) {
            $params = [
                'q'                     => $request->q,
                'type'                  => 'video',
                'part'                  => 'id, snippet',
                'regionCode'            => 'DE',
                'relevanceLanguage'     => 'DE',
                'maxResults'            => $request->maxResults
            ];
            $videos = Youtube::searchAdvanced($params);
        }

        return view('playlist.videos')->with([ 'playlist' => $playlist, 'videos' => $videos ]);
    }

    public function updateVideos(Request $request, Playlist $playlist) {
        if($request->has('sorting')) {
            foreach($request->video as $id => $sort) {
                $video = Video::findOrFail($id);
                $video->sort = $sort;
                $video->save();
            }
        } else {
            $videos = Youtube::getVideoInfo($request->video);
            foreach($videos as $key => $v) {
                $video = new Video([
                    'playlist_id' => $playlist->id,
                    'video_id' => $v->id,
                    'title' => $v->snippet->title,
                    'thumbnail_path' => isset($v->snippet->thumbnails->standard->url) ? $v->snippet->thumbnails->standard->url : $v->snippet->thumbnails->default->url,
                    'thumbnail_width' => isset($v->snippet->thumbnails->standard->width) ? $v->snippet->thumbnails->standard->width : $v->snippet->thumbnails->default->width,
                    'thumbnail_height' => isset($v->snippet->thumbnails->standard->height) ? $v->snippet->thumbnails->standard->height : $v->snippet->thumbnails->default->height,
                    'channel_id' => $v->snippet->channelId,
                    'channel_title' => $v->snippet->channelTitle,
                    'sort' => $key
                ]);
                $video->save();
            }

        }
        return view('playlist.videos')->with([ 'playlist' => $playlist, 'videos' => null ]);
    }
}
