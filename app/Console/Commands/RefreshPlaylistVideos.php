<?php

namespace App\Console\Commands;

use Alaouy\Youtube\Facades\Youtube;
use App\Playlist;
use App\Video;
use Illuminate\Console\Command;

class RefreshPlaylistVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes playlist videos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $playlists = Playlist::whereNotNull("playlist_id_yt")->get();
        foreach($playlists as $playlist) {
            if(!empty($playlist->playlist_id_yt)) {
                $nextPageToken = "";
                $sort = 0;
                do {
                    $playlistItems = Youtube::getPlaylistItemsByPlaylistId($playlist->playlist_id_yt, $nextPageToken);
                    $nextPageToken = $playlistItems['info']['nextPageToken'];
                    foreach ($playlistItems['results'] as $key => $item) {

                        $video = Video::firstOrCreate([
                            'playlist_id' => $playlist->id,
                            'video_id' => $item->snippet->resourceId->videoId,
                            'title' => $item->snippet->title,
                            'thumbnail_path' => isset($item->snippet->thumbnails->standard->url) ? $item->snippet->thumbnails->standard->url : $item->snippet->thumbnails->default->url,
                            'thumbnail_width' => isset($item->snippet->thumbnails->standard->width) ? $item->snippet->thumbnails->standard->width : $item->snippet->thumbnails->default->width,
                            'thumbnail_height' => isset($item->snippet->thumbnails->standard->height) ? $item->snippet->thumbnails->standard->height : $item->snippet->thumbnails->default->height,
                            'channel_id' => $item->snippet->videoOwnerChannelId,
                            'channel_title' => $item->snippet->videoOwnerChannelTitle,
                            'sort' => $sort
                        ]);
                        $video->save();
                        $sort++;
                    }
                } while($nextPageToken !== false);
            }
        }
        return 0;
    }
}
