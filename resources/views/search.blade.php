@extends('layouts.base')
@section('title')
  item
@endsection
@section('body')
<h1>Search</h1>
{{-- {{dd($searchResults->groupByType())}} --}}
There are {{ $searchResults->count() }} results.
  @foreach($searchResults->groupByType() as $type => $modelSearchResults)
     <h2>{{ $type }}</h2>
     @foreach($modelSearchResults as $searchResult)
         <ul>
{{-- {{dd($searchResult)}} --}}
              <li><a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a>
              	
              </li>
         </ul>
     @endforeach
  @endforeach
@endsection