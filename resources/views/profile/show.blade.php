@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$profileUser->name}}</h3>

                @forelse ($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>

                    @foreach ($activity as $record)
                        @if (view()->exists("profile.activities.{$record->type}"))
                            @include ("profile.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>There is no activity from the user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
