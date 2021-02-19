@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Videos</div>

                    <div class="panel-body">
                        @if($videos)
                        <form action="{{ route('playlist.updateVideos', $playlist) }}" method="post">
                        {{ csrf_field() }}
                            <table class="table table-responsive table-striped">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Title</th>
                                    <th>Channel</th>
                                </tr>
                                @forelse ($videos as $video)
                                    <tr>
                                        <td align="left"><input type="checkbox" name="video[]" value="{{ $video->id->videoId }}" /></td>
                                        <td><img src="{{ $video->snippet->thumbnails->default->url }}" width="{{ $video->snippet->thumbnails->default->width }}" height="{{ $video->snippet->thumbnails->default->height }}" /></td>
                                        <td align="left">{{ $video->snippet->title }}</td>
                                        <td align="left">{{ $video->snippet->channelTitle }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" class="bg-info" colspan="4">Keine Videos gefunden.</td>
                                    </tr>
                                @endforelse
                                    <tr>
                                        <td colspan="4"><input class="btn btn-success" type="submit" value="Hinzufügen" /></td>
                                    </tr>
                            </table>
                        </form>
                        @endif
                        <form action="{{ route('playlist.videos', $playlist) }}" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="q">Suche:</label>
                                        <input class="form-control" type="text" id="q" name="q" value="{{ old('q') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="maxResults">Max Results:</label>
                                        <select class="form-control" name="maxResults" id="maxResults">
                                            @for($i = 0; $i <= 50; $i = $i + 5)
                                                <option value="{{ $i }}" @if($i == 50) selected="selected" @endif>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="btn btn-success" type="submit" value="Suche" />
                                </div>
                            </div>
                        </form>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <form action="{{ route('playlist.updateVideos', $playlist) }}" method="post">
                                {{ csrf_field() }}
                                <table class="table table-responsive table-striped">
                                    <tr>
                                        <th>Title</th>
                                        <th>Channel</th>
                                        <th>Sort</th>
                                        <th></th>
                                    </tr>
                                    @forelse ($playlist->videos as $video)
                                        <tr>
                                            <td align="left"><a href="#">{{ $video->title }}</a></td>
                                            <td align="left">{{ $video->channel_title }}</td>
                                            <td align="left"><input type="text" name="video[{{$video->id}}]" value="{{ $video->sort }}" style="width: 50px;" /></td>
                                            <td align="right">
                                                <a class="right" href="{{ route('video.delete', ['video' => $video->id]) }}"><button class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td align="center" class="bg-info" colspan="4">Keine Videos gefunden.</td>
                                        </tr>
                                    @endforelse
                                </table>
                                <input class="btn btn-success" type="submit" name="sorting" value="Übernehmen" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection