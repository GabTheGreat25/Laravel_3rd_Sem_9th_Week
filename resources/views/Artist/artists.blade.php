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
{{-- Week 6 Import --}}
   <div class="col-xs-6">
       <form method="post" enctype="multipart/form-data" action="{{ url('/artist/import') }}">
          @csrf
        <input type="file" id="uploadName" name="artist_upload" required>
        
    </div>

  @error('artist_upload')
      <small>{{ $message }}</small>
    @enderror
         <button type="submit" class="btn btn-info btn-primary " >Import Excel File</button>
         </form> 
  </div>


<div><a href="#" data-toggle="modal" data-target="#artistModal">Add new Artist</a></div>
  <div >
    {{$html->table(['class' => 'table table-bordered table-striped table-hover '], true)}}
  </div>

<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#emailModal">Contact Us
    </button>
<div class="modal" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myemailLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
        <div class="modal-header text-center">
          <p class="modal-title w-100 font-weight-bold">Contact Us</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST" action="{{url('contact')}}">
        {{csrf_field()}}
          
        <div class="modal-body mx-3" id="mailModal">
          <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="name" style="display: inline-block;
            width: 150px; ">Send Email</label>
            <input type="text" id="sender" class="form-control validate" name="sender" placeholder="your name">
            <input type="text" id="title" class="form-control validate" name="title" placeholder="title">
            <textarea class="form-control validate" name="body" placeholder="Your message"></textarea>
          </div>
<div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Send </button>
            <button class="btn btn-light" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  
  <div class="modal" id="artistModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:75%;">
      <div class="modal-content">
<div class="modal-header text-center">
          <p class="modal-title w-100 font-weight-bold">Add New Artist</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form  method="POST" action="{{url('artista')}}">
        {{csrf_field()}}
        <div class="modal-body mx-3" id="inputfacultyModal">
          <div class="md-form mb-5">
            <i class="fas fa-user prefix grey-text"></i>
            <label data-error="wrong" data-success="right" for="name" style="display: inline-block;
          width: 150px; ">Artist Name</label>
            <input type="text" id="artist_name" class="form-control validate" name="artist_name">
          </div>
<div class="modal-footer d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Save</button>
            <button class="btn btn-light" data-dismiss="modal"> <i class="fas fa-paper-plane-o ml-1">Cancel</i></button>
          </div>
        </form>
 </div>
    </div>

  </div>
  @push('scripts')
    {{$html->scripts()}}
  @endpush
@endsection