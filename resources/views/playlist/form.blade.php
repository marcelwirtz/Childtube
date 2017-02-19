{{ csrf_field() }}
<div class="form-group">
    <label for="playlist_id">Playlist ID:</label>
    <input class="form-control" type="text" name="playlist_id" value="{{ old('playlist_id') }}" />
</div>
<div class="form-group pull-right">
    <input type="submit" class="btn btn-success" value="Absenden" />
    <a href="{{ route('playlist.index') }}"><button type="button" class="btn btn-danger">Abbrechen</button></a>
</div>