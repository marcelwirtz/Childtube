{{ csrf_field() }}
<div class="form-group">
    <label for="name">Name:</label>
    <input class="form-control" type="text" name="name" value="{{ old('name') }}" />
</div>
<div class="form-group">
    <label for="name">Thumbnail Path:</label>
    <input class="form-control" type="text" name="thumbnail_path" value="{{ old('thumbnail_path') }}" />
</div>
<div class="form-group">
    <label for="name">Thumbnail Width:</label>
    <input class="form-control" type="text" name="thumbnail_width" value="{{ old('thumbnail_width') }}" />
</div>
<div class="form-group">
    <label for="name">Thumbnail Height:</label>
    <input class="form-control" type="text" name="thumbnail_height" value="{{ old('thumbnail_height') }}" />
</div>
<div class="form-group">
    <label for="playlist_id">Playlist ID:</label>
    <input class="form-control" type="text" name="playlist_id_yt" value="{{ old('playlist_id_yt') }}" />
</div>
<div class="form-group pull-right">
    <input type="submit" class="btn btn-success" value="Absenden" />
    <a href="{{ route('playlist.index') }}"><button type="button" class="btn btn-danger">Abbrechen</button></a>
</div>