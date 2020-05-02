@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/vendor/tribute.css') }}" rel="stylesheet">
@endsection

@section('content')

<thread-view :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" v-cloak>
                @include('threads._question')
            </div>

            <div class="col-md-4">
                <div class="card">
                    <p>This post was published {{$thread->created_at->diffForHumans()}} by <a href="#">{{$thread->creator->name}}</a> and has <span v-text="repliesCount"></span> {{str_plural('comment', $thread->replies_count)}}.</p>

                    <p>
                        <subscription-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscription-button>

                        <button class="btn btn-default"
                                @click="lock"
                                v-if="authorize('admin')"
                                v-text="locked ? 'Unlock' : 'Lock'"></button>

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
