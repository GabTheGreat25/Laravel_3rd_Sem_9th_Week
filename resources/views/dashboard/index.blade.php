@extends('layouts.base')
@section('body')
<div  class="col-sm-6 col-md-6">
    <h2>Album chart</h2>
    @if(empty($genreChart))
        <div id="app2"></div>
    @else
    
        <div class="row">
            {!! $genreChart->container() !!}
        </div>
       
             {!! $genreChart->script() !!}
        
       
     @endif   
</div>

   <div  class="col-sm-6 col-md-6">
    <h2>listener chart</h2>
    @if(empty($listenerChart))
        <div id="app2"></div>
    @else
    
        <div class="row">
            {!! $listenerChart->container() !!}
        </div>
       
             {!! $listenerChart->script() !!}
        
     @endif   
</div>

@endsection