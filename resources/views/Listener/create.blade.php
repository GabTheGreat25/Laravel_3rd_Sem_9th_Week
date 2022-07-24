@extends('layouts.base')
@section('body')
<div class="container">
      <h2>Add new listener</h2><br/>
      <form method="post" action="{{url('listener')}}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="listener_name">Listener Name:</label>
            <input type="text" class="form-control" name="listener_name">
          </div>

          </div>
        <div class="row">
          <div class="col-md-4"></div>
        <div class="form-group col-md-4">
       {{--  @foreach ($albums as $id => $album) 
          <div class="form-check form-check-inline">
           {!! Form::checkbox('album_id[]',$id, null, array('class'=>'form-check-input','id'=>'album')) !!} 
           {!!Form::label('album', $album,array('class'=>'form-check-label')) !!}
           </div>
          @endforeach 
            </div> 

            </div> --}}

            @foreach($albums as $album ) 
        {{-- {{dump($album->artist->artist_name)}} --}}
           <div class="form-check form-check-inline">
             {{ Form::checkbox('album_id[]',$album->id, null, array('class'=>'form-check-input','id'=>'album')) }} 
              {!!Form::label('album', $album->album_name. ' by '.$album->artist->artist_name ,array('class'=>'form-check-label')) !!}

              {{-- {!!Form::label('artist', $album->artist->artist_name,array('class'=>'form-check-label')) !!} --}}
             </div> 
            
        @endforeach
          </div>  
        </div>



        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
@endsection 