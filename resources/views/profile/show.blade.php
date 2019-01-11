@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$profileUser->name}}</h3>
                <small>Member since {{ $profileUser->created_at->diffForHumans() }}</small>


                @foreach($threads as $thread)
                    <div class="card mt-4">
                        <div class="card-header">
                            <a href="/profiles/{{ $profileUser->name }}">
                                {{ $profileUser->name }}
                            </a>
                            posted: <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            <small class="float-right">{{ $thread->created_at->diffForHumans() }}</small>
                        </div>

                        <div class="card-body">
                            <article>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
