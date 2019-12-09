<div class="card my-3" id="reply-{{ $reply->id }}">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <a href="{{ route('profiles.show', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
                said {{ $reply->created_at->diffForHumans() }}
            </span>
            @auth
            <span class="ml-auto">
                <form action="{{ route('favorites.store', $reply->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        {{ $reply->favorites_count }} {{ Str::plural('favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </span>
            @endauth
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
    @can('update', $reply)
    <div class="card-footer">
        <form action="{{ route('replies.destroy', $reply) }}" method="post">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Delete Reply</button>
        </form>
    </div>
    @endcan
</div>
