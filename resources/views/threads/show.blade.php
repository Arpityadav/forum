@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/vendor/tribute.css') }}" rel="stylesheet">
@endsection

@section('content')

<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">
                        <a href="/profiles/{{ $thread->creator->name }}">
                            {{ $thread->creator->name }}
                        </a> posted : {{ $thread->title }}

                        @can('update', $thread)
                            <form action="{{ $thread->path() }}" method="POST" class="d-inline float-right">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger">Delete</button>
                            </form>
                        @endcan
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <p>This post was published {{$thread->created_at->diffForHumans()}} by <a href="#">{{$thread->creator->name}}</a> and has <span v-text="repliesCount"></span> {{str_plural('comment', $thread->replies_count)}}.</p>

                    <p>
                        <subscription-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscription-button>
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <replies @added="repliesCount++" @removed="repliesCount--"></replies>
            </div>
        </div>

    </div>
</thread-view>
@endsection
