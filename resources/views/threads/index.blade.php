@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @include('threads._list')

                {{ $threads->render() }}
            </div>
        </div>
    </div>
@endsection
