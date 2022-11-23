<x-app-layout>
    @slot('title')
        Field Groups
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Field Groups for {{ $form->name }}
        </x-subheader-comp>
    </x-slot>

    <x-common-for-index :html="$html"></x-common-for-index>
</x-app-layout>
