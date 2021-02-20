@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @forelse($playlists AS $key => $playlist)
                @if($key > 0 && $key % 3 == 0)
                    </div>
                    <div class="row">
                @endif
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body text-center">
                            <a href="{{route("playlist.show", ['playlist' => $playlist->id])}}"><img src="{{$playlist->thumbnail_path}}" style="min-width: 328px; min-height: 246px; width:100%; height: 100%; max-width: {{$playlist->thumbnail_width}}px; max-height: {{$playlist->thumbnail_height}}px;"></a>
                        </div>
                        <div class="panel-footer text-center"><a href="{{route("playlist.show", ['playlist' => $playlist->id])}}">{{$playlist->name}}</a></div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 bg-info">Keine Playlists vorhanden!</div>
            @endforelse
        </div>
    </div>
@endsection