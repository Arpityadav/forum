@component('profile.activities.activity')
    @slot('header')
        <a href="/profiles/{{ $profileUser->name }}">
            {{ $profileUser->name }}
        </a> replies to a thread:
        <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>

        <small class="float-right">{{ $activity->subject->created_at->diffForHumans() }}</small>
    @endslot

    @slot('body')
        <div class="body">{{ $activity->subject->body }}</div>
    @endslot
@endcomponent