@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')

                {{ $threads->render() }}
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        Search
                    </div>
                    <div class="card-body">
                        <form action="/threads/search" method="GET">
                            <div class="form-group">
                                <input type="text" name="q" class="form-control" placeholder="Search anything here...">
                            </div>
                            <button class="btn btn-info" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                @if ($trending)
                    <div class="card">
                        <div class="card-header">
                            Trending threads
                        </div>

                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($trending as $thread)
                                    <a href="{{ $thread->path }}">
                                        <li class="list-group-item">{{ $thread->title }}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
