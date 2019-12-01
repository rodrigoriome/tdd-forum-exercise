@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->user->name }}</a>
                    posted:
                    {{ $thread->title }}
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>

            @foreach ($replies as $reply)
            @include ('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if(auth()->check())
            <hr>
            <form action="{{ route('reply.store', [$thread->channel->slug, $thread->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" rows="5" placeholder="Have something to say?"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Reply</button>
            </form>
            @else
            <hr>
            <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was published {{ $thread->created_at->diffForHumans() }}
                    by <a href="#!">{{ $thread->user->name }}</a>
                    and currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
