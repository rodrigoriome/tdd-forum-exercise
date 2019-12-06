@component('profiles.activities.activity', compact('activity'))
@slot('heading')
<a href="{{ route('profiles.show', $activity->subject->owner->name) }}">
    {{ $activity->subject->owner->name }}
</a>
replied to
<a href="{{ $activity->subject->thread->path() }}">
    {{ $activity->subject->thread->title }}
</a>
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot
@endcomponent
