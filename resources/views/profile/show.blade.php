@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$profileUser->name}}</h3>

                @foreach($activities as $date => $records)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach($records as $activity)
                        @if(isset($activity))
                            @include("profile.activities.{$activity->type}")
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
