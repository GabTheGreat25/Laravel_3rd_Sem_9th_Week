@extends('layouts.base')
@section('body')
<div class="container">
  <h2>Create new album</h2>
  <form method="post" action="{{route('album.store')}}" enctype="multipart/form-data" >
  <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->

  @csrf
  <div class="form-group">
    <label for="album_name" class="control-label">Album Name</label>
    <input type="text" class="form-control" id="album_name" name="album_name" >
  </div> 

<div class="form-group">
    <label for="image" class="control-label">Album Cover</label>
    <input type="file" class="form-control" id="image" name="image" >
    @error('image')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div> 



<div class="form-group"> 
    <label for="artists">Choose an Artist:</label>
    <select name="artist_id" id="artists" class="form-select" >
      @foreach($artists as $artist)
        <option value="{{$artist->id}}">{{$artist->artist_name}}</option>
      @endforeach
    </select>
  </div>

  
  <div class="form-group"> 
    <label for="genre" class="control-label">Genre</label>
    <input type="text" class="form-control " id="genre" name="genre" >
  </div>
<div class="form-group"> 
    <label for="year" class="control-label">Year</label>
    <input type="text" class="form-control" id="year" name="year">
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </form> 
</div>
</div>
@endsection