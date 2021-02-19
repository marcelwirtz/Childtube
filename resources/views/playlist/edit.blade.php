@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Playlist bearbeiten</div>

                    <div class="panel-body">
                        <form action="{{ route('playlist.update') }}" method="post">
                            <input type="hidden" name="playlist_id" value="{{ $playlist->id }}" />
                            @include("playlist.form")
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection