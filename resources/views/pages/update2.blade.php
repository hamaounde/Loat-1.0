@extends('layouts.app')

@section('content')

<h3>Modification</h3>
    {!! Form::open(['action' => ['LocationsController@destroy', $locations->id], 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class', => 'form-control', 'palceholder' => 'title'] ) }}
        </div>

        <div> </div>
    {!! Form::close() !!}
@endsection
