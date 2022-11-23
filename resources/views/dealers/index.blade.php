<x-app-layout>
    @slot('title')
    Dealers List
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Dealers List
            @slot('actions')
                {!! Html::decode(link_to_route('dealers.create', '<i class="fa fa-plus"></i> New dealer', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <x-common-for-index :html="$html"></x-common-for-index>
</x-app-layout>
