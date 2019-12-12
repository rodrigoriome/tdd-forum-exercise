@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mt-4 mb-5 border-bottom">
                <h1>
                    {{ $profileUser->name }}
                </h1>
            </div>
            @forelse ($activities as $date => $activity)
            <h3>{{ $date }}</h3>
            @foreach ($activity as $record)
            @if (view()->exists("profiles.activities.{$record->type}"))
            @include("profiles.activities.{$record->type}", ['activity' => $record])
            @endif
            @endforeach
            @empty
            <p class="text-center">There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
