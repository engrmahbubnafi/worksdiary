<x-app-layout>
    <x-slot name="subheader">
        <x-subheader-comp>
            Demos
            <!--begin::Separator-->
            <span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-1"></span>
            <!--end::Separator-->
            <!--begin::Description-->
            <span class="text-muted fs-7 fw-bold mt-2">Folder List</span>
            <!--end::Description-->
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0">
                <h3 class="card-title fw-bolder text-dark">Folders</h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-2">
                <!--begin::Item-->
                <div class="d-flex align-items-center mb-7">
                    <!--begin::Text-->
                    <div class="flex-grow-1">
                        <ul style="list-style: none;">
                            @foreach ($folders as $folder)
                                <li style="padding-bottom: 10px;">
                                    <a href="{{ route('demos.fileList', $folder) }}"
                                        class="text-dark fw-bolder text-hover-primary fs-6">
                                        {{ Str::ucfirst(str_replace('-', ' ', basename($folder))) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--end::Text-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Body-->
        </div>
    </div>
</x-app-layout>
