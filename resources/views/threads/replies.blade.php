<div class="card my-3">
    <div class="card-header">
        <a href="/profiles/{{ $reply->owner->name }}" class="flex">
            {{ $reply->owner->name }}
        </a> said {{ $reply->created_at->diffForHumans() }}

        <form action="/replies/{{ $reply->id }}/favorites" method="POST" class="d-inline float-right">
            @csrf
            <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
            </button>
        </form>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
