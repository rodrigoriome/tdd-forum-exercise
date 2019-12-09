@component('profiles.activities.activity', compact('activity'))
@slot('heading')
{{ $activity->subject->user->name }} published
<a href="{{ $activity->subject->path() }}">
    {{ $activity->subject->title }}
</a>
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot
@endcomponent
