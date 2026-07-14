<div class="team-card">
    <img src="{{ asset('storage/'.$member->photo) }}">

    <h4>{{ $member->full_name }}</h4>

    <p>{{ $member->position }}</p>
</div>

@if($member->childrenRecursive->count())
    <div class="team-grid ms-4">
        @foreach($member->childrenRecursive as $child)
            @include('components.organization-tree', ['member' => $child])
        @endforeach
    </div>
@endif