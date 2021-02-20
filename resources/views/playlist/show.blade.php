@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($playlist->videos AS $key => $video)
                <div class="col-md-4" style="height: 350px;">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a onclick="showVideo('{{ $video->video_id }}');"><img src="{{ isset($video->thumbnail_path) ? $video->thumbnail_path : '' }}" style="cursor:pointer; width:100%; height: 100%; max-width: 328px; max-height: 246px;"></a>
                        </div>
                        <div class="panel-footer text-center"><a onclick="showVideo('{{ $video->video_id }}');" style="cursor: pointer;">{{ $video->title }}</a></div>
                    </div>
                </div>
                @if($key % 3 == 0)
                    </div>
                    <div class="row">
                @endif
            @endforeach
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