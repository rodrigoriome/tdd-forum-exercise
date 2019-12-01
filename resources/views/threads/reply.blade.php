<div class="card my-3">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <a href="#">{{ $reply->owner->name }}</a>
                said {{ $reply->created_at->diffForHumans() }}
            </span>
            {{-- @auth --}}
            <span class="ml-auto">
                <form action="{{ route('favorites.store', $reply->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary"
                        {{ $reply->isFavoritedByUser() ? 'disabled' : '' }}>
                        {{ $reply->favorites()->count() }} {{ Str::plural('favorite', $reply->favorites()->count()) }}
                    </button>
                </form>
            </span>
            {{-- @endauth --}}
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
