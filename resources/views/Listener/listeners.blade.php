@extends('layouts.base')
@section('body')
    <div class="container">
        <br />
        @if (Session::has('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div><br />
        @endif
    </div>



    <div class="col-xs-6">
        <form method="post" enctype="multipart/form-data" action="{{ url('/listener/import') }}">
            @csrf
            <input type="file" id="uploadName" name="listener_upload" required>

    </div>

    @error('listener_upload')
        <small>{{ $message }}</small>
    @enderror
    <button type="submit" class="btn btn-info btn-primary ">Import Excel File</button>
    </form>
    </div>
    <div><button type="button" class="btn btn-sm" data-toggle="modal" data-target="#listenerModal">
            create new Listener
        </button></div>
    <div>
        {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover '], true) }}
    </div>
    <div class="modal" id="listenerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width:75%;">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <p class="modal-title w-100 font-weight-bold">Add New Listener/p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="post" action="{{ url('listener') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{-- <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Name">listener Name:</label>
            <input type="text" class="form-control" name="listener_name">
          </div>
        </div> --}}


                    <div class="row">
                        <div class=" form-group col-md-4">

                            <label for="Name">listener Name:</label>
                            <input type="text" class="form-control" name="listener_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-4">
                            @foreach ($albums as $album)
                                {{-- {{dd($album)}} --}}
                                <div class="form-check form-check-inline">
                                    {{ Form::checkbox('album_id[]', $album->id, null, ['class' => 'form-check-input', 'id' => 'album']) }}
                                    {!! Form::label('album', $album->album_name . ' by ' . $album->artist->artist_name, [
                                        'class' => 'form-check-label',
                                    ]) !!}
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
        </div>

    </div>
    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
@endsection
