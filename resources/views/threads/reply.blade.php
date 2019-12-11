<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-html="body"></div>
        </div>
        @can('update', $reply)
        <div class="card-footer d-flex">
            <button type="submit" class="btn btn-sm btn-outline-primary mr-3" @click="editing = true">Edit</button>
            <form action="{{ route('replies.destroy', $reply) }}" method="post" class="mr-3">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
        @endcan
    </div>
</reply>
