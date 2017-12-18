@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($videos AS $video)
                <div class="col-md-3" style="height: 350px;">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a onclick="showVideo('{{$video->contentDetails->videoId}}');"><img src="{{ isset($video->snippet->thumbnails->standard->url) ? $video->snippet->thumbnails->standard->url : $video->snippet->thumbnails->default->url }}" style="cursor:pointer; width:100%; height: 100%; max-width: 328px; max-height: 246px;"></a>
                        </div>
                        <div class="panel-footer text-center"><a onclick="showVideo('{{$video->contentDetails->videoId}}');" style="cursor: pointer;">{{$video->snippet->title}}</a></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <ul class="pagination pagination-lg">
                    <li @if(!$prevPageToken) class="disabled" @endif><a href="{{route("playlist.show", ["playlist" => $playlist->id, "pageToken" => $prevPageToken])}}" aria-label="Previous"><span aria-hidden="true">Zur&uuml;ck</span></a></li>
                    <li @if(!$nextPageToken) class="disabled" @endif><a href="{{route("playlist.show", ["playlist" => $playlist->id, "pageToken" => $nextPageToken])}}" aria-label="Next"><span aria-hidden="true">Weiter</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel">
        <div class="modal-dialog modal-lg" role="document" style="width: 80%; height: 80%;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="videoFrame" class="embed-responsive-item" src=""></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Schlie&szlig;en</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function closeModal() {
            $("#videoFrame").attr("src", "");
            $('#videoModal').modal('hide');
        }
        function showVideo(videoId) {
            $("#videoFrame").attr("src", "https://www.youtube-nocookie.com/embed/"+ videoId + "?rel=0&modestbranding=1&fs=1");
            $('#videoModal').modal('show');
        }
    </script>
@endsection