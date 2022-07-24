@extends('layouts.app')
@section('content')
    <div class="container">
    <br />
    @if ( Session::has('success'))
      <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
      </div><br />
     @endif



  {{-- @include('partials.search') --}}
<table class="table table-striped">
      <p>{{ link_to_route('album.index', 'Albums')}}</p>
      <tr>{{ link_to_route('artist.create', 'Add new artist:')}}</tr>
    <thead>

      <form method="GET" action="{{url('search')}}" >
       <div class="form-group col-md-4">
            <label for="genre">Search</label>
            <input type="text" class="form-control" name="search" id="genre">
    </div>
     </form>



      <tr>
        <th>Artist ID</th>
        <th>Artist Name</th>
        <th>Album Name</th>
        <th>Genre</th>
         <th>Image</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
<tbody>
     {{-- dd($artists) --}}
      @foreach($artists as $artist)
      <tr>
        <td>{{$artist->id}}</td>
        <td>{{$artist->artist_name}}</td>


        <td>


          
       {{--  @foreach($artist->albums as $album)
          <li>{{$album->}} </li>  
        @endforeach --}}
        </td>
        <td>
      {{$artist->album_name}}
        </td>
        <td>
          @foreach($artist->albums as $album)
          <li>{{$album->album_name}} Genre: {{$album->genre}}  </li>  
        @endforeach
      </td>
        <td><img src="{{ asset('storage/images/'.$artist->img_path) }}"  style="width:200px;height:200px"/></td>
<td><a href = "{{ route('artist.show', $artist->id ) }}"  class="btn btn-warning">show</a></td>
        <td>
        <td><a href="{{ action('ArtistController@edit', $artist->id)}}" class="btn btn-warning">Edit</a></td>
        <td>
          <!-- <form action="{{ action('ArtistController@destroy', $artist->id)}}" method="post">
           {{ csrf_field() }}
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
         -->
                    {!! Form::open(array('route' => array('artist.destroy', $artist->id),'method'=>'DELETE')) !!}
           <button class="btn btn-danger" type="submit">Delete</button>
           {!! Form::close() !!}
         </td>
 </form>
        </td>
      </tr>
      @endforeach
@endsection