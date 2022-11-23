<x-app-layout>
    @slot('title')
        Area List
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Area List for Zone: "{{ $zone->name }}" and Company: "{{ $company->name }}"

            @slot('actions')
                {{-- Zone List button --}}
                {!! Html::decode(
                    link_to_route(
                        'zones.index',
                        '<i class="fa fa-list"></i> Zone List',
                        auth()->user()->company_id != $company->id ? $company->id : null,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}

                {{-- New Area button --}}
                {!! Html::decode(
                    link_to_route(
                        'companies.zones.areas.create',
                        '<i class="fa fa-plus"></i> New Area',
                        [$company->id, $zone->id],
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <x-common-for-index :html="$html"></x-common-for-index>
</x-app-layout>
