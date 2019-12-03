@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h1>
                    {{ $profileUser->name }}
                    <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
                </h1>
            </div>

            {{ $threads->links() }}
            @foreach ($threads as $thread)
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <a href="{{ route('profiles.show', $thread->user->name) }}">{{ $thread->user->name }}</a>
                        posted:
                        {{ $thread->title }}
                    </span>
                    <span>
                        {{ $thread->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            @endforeach
            {{ $threads->links() }}
        </div>
    </div>
</div>
@endsection
