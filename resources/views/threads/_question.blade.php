<div class="card" v-if="editing">

    <div class="card-header">

        <input type="text" class="form-control" v-model="form.title">

    </div>

    <div class="card-body">
        <div class="form-group">
            <textarea  rows="10" class="form-control" v-model="form.body"></textarea>
        </div>
    </div>

    <div class="card-footer">
        <button class="btn btn-xs" @click="editing = true" v-show="! editing">Edit</button>
        <button class="btn btn-primary btn-xs" v-show="editing" @click="update">Update</button>

        <button class="btn btn-xs" @click="resetForm">Cancel</button>

        @can('update', $thread)
            <form action="{{ $thread->path() }}" method="POST" class="d-inline float-right">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">Delete</button>
            </form>
        @endcan
    </div>


</div>


<div class="card" v-else>

    <div class="card-header">
        <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="40" height="40" class="rounded-circle mr-2">

        <a href="/profiles/{{ $thread->creator->name }}">
            {{ $thread->creator->name }}
        </a> posted : <span v-text="title"></span>

        @can('update', $thread)
            <form action="{{ $thread->path() }}" method="POST" class="d-inline float-right">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">Delete</button>
            </form>
        @endcan
    </div>

    <div class="card-body" v-text="body"></div>

    <div class="card-footer" v-show="authorize('owns', thread)">
        <button class="btn btn-xs" @click="editing = true" >Edit</button>
    </div>

</div>
