@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    <a href="#">
                        {{ $thread->creator->name }}
                    </a> posted : {{ $thread->title }}</div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    @foreach ($thread->reply as $reply)
        <div class="row justify-content-center mt-2">
            <div class="col-md-8">
                @include('threads.replies')
            </div>
        </div>
    @endforeach

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            @guest
                <p class="text-center">You have to <a href="{{ route('login') }}">login</a> to participate in this discussion.</p>
            @else
                <form action="{{ $thread->path() }}./replies" method="POST">
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
