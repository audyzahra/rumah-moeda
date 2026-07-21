<div class="tree-node">

    <div class="tree-card">
        <img src="{{ $member->photo_url }}" alt="{{ $member->full_name }}">

        <h4>{{ $member->full_name }}</h4>

        <span>{{ $member->position }}</span>
    </div>

    @if($member->childrenRecursive->count())

        <div class="tree-line"></div>

        <div class="tree-children">

            @foreach($member->childrenRecursive as $child)

                <div class="tree-child">

                    <div class="tree-child-line"></div>

                    @include('components.organization-tree', [
                        'member' => $child
                    ])

                </div>

            @endforeach

        </div>

    @endif

</div>