@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3>{{$profileUser->name}}</h3>
                <small>Member since {{ $profileUser->created_at->diffForHumans() }}</small>

                <div class="card">
                    <div class="card-header">Forum threads</div>

                    @foreach($threads as $thread)
                    <div class="card-body">
                        <article>
                            <h4>
                                <a href="{{ $thread->path() }}">
                                    {{ $thread->title }}
                                </a>
                            </h4>
                            <div class="body">{{ $thread->body }}</div>
                        </article>
                    </div>
                    @endforeach
                </div>

                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
