@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <ais-index
                app-id="{{ config('scout.algolia.id') }}"
                api-key="{{ config('scout.algolia.key') }}"
                index-name="threads"
                query="{{ request('q') }}"
                class="row">

                <div class="col-md-8">
                    <ais-results>
                        <template slot-scope="{ result }">
                            <li>
                                <a :href="result.path">
                                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                </a>
                            </li>
                        </template>
                    </ais-results>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            Search
                        </div>
                        <div class="card-body">
                            <ais-input placeholder="Find a thread..." autofocus="true" class="form-control"></ais-input>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            Filter by channel
                        </div>
                        <div class="card-body">
                            <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
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
            </ais-index>
        </div>
    </div>
@endsection
