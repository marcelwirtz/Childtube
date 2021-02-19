@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Playlists</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12"><a href="{{ route('playlist.create') }}"><button type="button" class="btn btn-success pull-right">Hinzufügen</button></a></div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <table class="table table-responsive table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Playlist ID</th>
                                        <th colspan="2">Videos</th>
                                    </tr>
                                    @forelse ($playlists as $playlist)
                                        <tr>
                                            <td align="left"><a href="#">{{ $playlist->name }}</a></td>
                                            <td align="left">{{ $playlist->playlist_id }}</td>
                                            <td align="left">{{ $playlist->number_of_videos }}</td>
                                            <td align="right">
                                                <a class="right" href="{{ route('playlist.videos', ['playlist' => $playlist->id]) }}"><button class="btn btn-sm btn-info"><span class="glyphicon glyphicon-film"></span></button></a>
                                                <a class="right" href="{{ route('playlist.delete', ['playlist' => $playlist->id]) }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td align="center" class="bg-info" colspan="4">Keine Playlists gefunden.</td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection