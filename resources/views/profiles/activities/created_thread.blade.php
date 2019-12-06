@component('profiles.activities.activity', compact('activity'))
@slot('heading')
<a href="{{ route('profiles.show', $activity->subject->user->name) }}">
    {{ $activity->subject->user->name }}
</a>
published
<a href="{{ $activity->subject->path() }}">
    {{ $activity->subject->title }}
</a>
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot
@endcomponent
