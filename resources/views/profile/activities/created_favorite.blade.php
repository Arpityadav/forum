@component('profile.activities.activity')
    @slot('header')
        <a href="{{$activity->subject->favorited->path() }}">
            {{ $profileUser->name }}
        favorites a reply
        </a>
    @endslot

    @slot('body')
        <div class="body">{{ $activity->subject->favorited->body }}</div>
    @endslot
@endcomponent