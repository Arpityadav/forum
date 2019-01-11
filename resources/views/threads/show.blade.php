@extends('layouts.app')

@section('content')
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
                <p>This post was published {{$thread->created_at->diffForHumans()}} by <a href="#">{{$thread->creator->name}}</a> and has {{$thread->replies_count}} {{str_plural('comment', $thread->replies_count)}}.</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8">

            @foreach ($replies as $reply)
                @include('threads.replies')
            @endforeach

            {{$replies->links()}}
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8 ">
            @guest
            <p class="text-center">You have to <a href="{{ route('login') }}">login</a> to participate in this discussion.</p>
            @else
            <form action="{{ $thread->path() }}./replies" method="POST" >
                @csrf

                <div class="form-group">
                    <textarea name="body" class="form-control" rows="5" placeholder="Have something to say?"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-default" type="submit">Post</button>
                </div>
            </form>
            @endguest
        </div>
    </div>

</div>
@endsection
