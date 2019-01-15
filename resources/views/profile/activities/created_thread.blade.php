@component('profile.activities.activity')
    @slot('header')
        <a href="/profiles/{{ $profileUser->name }}">
            {{ $profileUser->name }}
        </a> published a thread
        <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>

        <small class="float-right">{{ $activity->subject->created_at->diffForHumans() }}</small>
    @endslot

    @slot('body')
        <div class="body">{{ $activity->subject->body }}</div>
    @endslot
@endcomponent
