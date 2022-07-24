@extends('layouts.base')
@section('body')
  <div class="container">
    <br />
    @if ( Session::has('success'))
      <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
      </div><br />
     @endif
  </div>
  <div class="col-xs-6">
       <form method="post" enctype="multipart/form-data" action="{{ url('/album/import') }}">
          @csrf
        <input type="file" id="uploadName" name="album_upload" required>
        
    </div>
  
    @error('album_upload')
     <small>{{ $message }}</small>
    @enderror
         <button type="submit" class="btn btn-info btn-primary " >Import Excel File</button>
         </form> 
  </div>
 <div><button type="button" class="btn btn-sm" data-toggle="modal" data-target="#albumModal">
  create new album
</button></div>
  <div >
    {{$dataTable->table(['class' => 'table table-bordered table-striped table-hover '], true)}}
  </div>
<div class="modal" id="albumModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
<div class="modal-header text-center">
          <p class="modal-title w-100 font-weight-bold">Add New Album</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST" action="{{url('album')}}">
        {{csrf_field()}}
          
<div class="modal-body mx-3" id="inputAlbumModal">
          <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="name" style="display: inline-block;
          width: 150px; ">Album Name</label>
            <input type="text" id="album_name" class="form-control validate" name="album_name">
          </div>
<div class="md-form mb-5">
            <label for="artist">artist:</label>
              {!! Form::select('artist_id', App\Models\Artist::pluck('artist_name','id'), null,['class' => 'form-control']) !!}
           </div>
           <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="genre" style="display: inline-block;
          width: 150px; ">Genre</label>
            <input type="text" id="genre" class="form-control validate" name="genre">
          </div>
<div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Save</button>
            <button class="btn btn-light" data-dismiss="modal">Cancel</button>
          </div>
        </form>
</div>
    </div>
    
  </div>
  @push('scripts')
    {{$dataTable->scripts()}}
  @endpush
@endsection