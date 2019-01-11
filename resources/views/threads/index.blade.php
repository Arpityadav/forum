@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @forelse ($threads as $thread)
                    <div class="card mb-4">
                        <div class="card-header">
                            <a href="{{ $thread->path() }}">
                                {{ $thread->title }}
                            </a>
                            <small class="float-right" href="{{ $thread->path() }}">
                                {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                            </small>
                        </div>

                        <div class="card-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                @empty
                    <p>No threads are found at the moment</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
