@extends('layouts.base')
@section('body')
<div class="container">
  <h2>Create new artist</h2>
  <form method="POST" action="{{route('artist.store')}}"  enctype="multipart/form-data" >
  @csrf
  <div class="form-group">
    <label for="artist_name" class="control-label">Artist Name</label>
    <input type="text" class="form-control" id="artist_name" name="artist_name" require ="true" >
  </div> 
  @if($errors->has('artist_name'))
      <small>{{ $errors->first('artist_name') }}</small>
    @endif

    <div class="form-group">
    <label for="image" class="control-label">Artist Image</label>
    <input type="file" class="form-control" id="image" name="image" >
    @error('image')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
   
  </div>
<button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </form>
</div>
@endsection