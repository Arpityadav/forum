<reply inline-template :attributes="{{ $reply }}" v-cloak>

    <div id="reply-{{$reply->id}}" class="card my-3">
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
            <div v-if="editing">
                <textarea class="form-control" v-model="body"></textarea>

                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-footer">
                <button class="btn" @click="editing = true">Edit</button>
                <form action="/replies/{{  $reply->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endcan
    </div>

</reply>