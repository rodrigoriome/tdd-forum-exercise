@component('profiles.activities.activity', compact('activity'))
@slot('heading')
{{ $profileUser->name }} favorited
<a href="{{ $activity->subject->favorited->path() }}">
    a reply
</a>
from
<a href="{{ route('profiles.show', $activity->subject->favorited->owner->name) }}">
    {{ $activity->subject->favorited->owner->name }}
</a>
@endslot

@slot('body')
{{ $activity->subject->favorited->body }}
@endslot
@endcomponent
