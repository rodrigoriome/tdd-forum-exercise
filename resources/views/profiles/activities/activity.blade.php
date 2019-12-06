<div class="card my-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            {{ $heading }}
        </span>
        <span>
            {{ $activity->created_at->diffForHumans() }}
        </span>
    </div>
    <div class="card-body">
        {{ $body }}
    </div>
</div>
