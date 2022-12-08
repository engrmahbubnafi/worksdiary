<x-app-layout>
    <x-slot name="subheader">
        <x-subheader-comp>
            Dashboard
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="text-center">
            <x-tab-comp :lists="$lists" :common-param="'dashboard'" :is-comon-param-added-to-route="false"></x-tab-comp>
        </div>

        <h1 class="pt-10">Coming soon...</h1>
    </div>
</x-app-layout>
