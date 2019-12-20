@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <a href="{{ route('profiles.show', $thread->user->name) }}">{{ $thread->user->name }}</a>
                            posted:
                            {{ $thread->title }}
                        </span>
                        @can('update', $thread)
                        <span>
                            <form action="{{ route('threads.destroy', [$thread->channel, $thread]) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Delete Thread</button>
                            </form>
                        </span>
                        @endcan
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                <replies :channel="{{ $thread->channel }}" @added="repliesCount++" @removed="repliesCount--" />
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }}
                        by <a href="#!">{{ $thread->user->name }}</a>
                        and currently has <span v-text="repliesCount"></span>
                        {{ Str::plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
