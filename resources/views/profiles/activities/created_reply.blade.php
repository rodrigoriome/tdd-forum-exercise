@component('profiles.activities.activity', compact('activity'))
@slot('heading')
{{ $activity->subject->owner->name }} replied to
<a href="{{ $activity->subject->thread->path() }}">
    {{ $activity->subject->thread->title }}
</a>
@endslot

@slot('body')
{{ $activity->subject->body }}
@endslot
@endcomponent
