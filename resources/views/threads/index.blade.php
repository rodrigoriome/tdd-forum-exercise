@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse ($threads as $thread)
            <div class="card my-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="mb-0">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </h4>
                        <a href="{{ $thread->path() }}">
                            {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
            @empty
            <p class="text-center">Heads up! There are not threads for this channel.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
