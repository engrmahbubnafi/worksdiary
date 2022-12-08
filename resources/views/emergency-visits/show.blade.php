<x-app-layout>
    @slot('title')
        Task Details
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Task Details

            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'emergency.visits.index',
                        '<i class="fa fa-list"></i> Emmergency Task List',
                        $companyId != auth()->user()->company_id ? $companyId : null,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                {{-- Profile Details --}}
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">{{ $emergencyVisit->name }}</h3>
                        </div>
                    </div>

                    <div class="card-body p-9">
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Assignee</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800">{{ $emergencyVisit->assaigned_name }}</span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Company</label>
                            <div class="col-lg-8">
                                <span class="fw-bold text-gray-800 fs-6">{{ $emergencyVisit->company_name }}</span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Zone</label>
                            <div class="col-lg-8">
                                <span class="fw-bold text-gray-800 fs-6">{{ $emergencyVisit->zone_name }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Unit Code</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800">{{ $emergencyVisit->unit_code }}</span>
                            </div>
                        </div>
                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Unit</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800">{{ $emergencyVisit->unit_name }}</span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Status</label>
                            <div class="col-lg-8 fv-row">
                                <span
                                    class="fw-bold text-gray-800 fs-6">{{ str()->of($emergencyVisit->status)->snake(' ')->title() }}</span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Note</label>
                            <div class="col-lg-8 fv-row">
                                <span class="fw-bold text-gray-800 fs-6">{{ $emergencyVisit->task_note }}</span>
                            </div>
                        </div>
                        <!--end::Input group-->


                        {{-- images --}}
                        @if ($emergencyVisit->emergencyTaskImages)
                            <div class="notice bg-light-warning rounded border-warning border border-dashed p-6">
                                <div class="row">
                                    @foreach ($emergencyVisit->emergencyTaskImages as $emergencyTaskImage)
                                        <div class="col-lg-4"> <img class="img-fluid"
                                                src="{{ asset('storage/emergency_task/' . $emergencyTaskImage->img) }}"
                                                alt="image" /></div>
                                    @endforeach


                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
