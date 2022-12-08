<x-app-layout>
    @slot('title')
        Visit Details
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Visit Details
            @slot('actions')
                {!! Html::decode(
                    link_to_route('companies.visits.edit', '<i class="fa fa-edit"></i> Edit', [$companyId,$visit->id], [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
                {!! Html::decode(
                    link_to_route('visits.index', '<i class="fa fa-list"></i> Visit List', $companyId != auth()->user()->company_id ? $companyId : null, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Inbox App - View & Reply -->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-lg-275px mb-10 mb-lg-0">
                    <!--begin::Sticky aside-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="inbox-aside-sticky" data-kt-sticky-offset="{default: false, xl: '0px'}" data-kt-sticky-width="{lg: '275px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Aside content-->
                        <div class="card-body">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">
                                <!--begin::Menu item-->
                                <a href="{{ route('companies.visits.show',[$companyId,$visit->id]) }}">
                                    <div class="menu-item mb-3">
                                        <!--begin::Inbox-->
                                        <span class="menu-link @if(!$formId) active @endif">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                                <span class="svg-icon svg-icon-2 me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <span class="menu-title fw-bolder">Overview</span>
                                            {{-- <span class="badge badge-light-success">3</span> --}}
                                        </span>
                                        <!--end::Inbox-->
                                    </div>
                                </a>
                                <!--end::Menu item-->
                                @if($forms->count())
                                    @foreach ($forms as $id=>$formName)
                                        <!--begin::Menu item-->
                                        <a href="{{ route('companies.visits.show',[$companyId,$visit->id,'formId='.$id]) }}">
                                            <div class="menu-item mb-3">
                                                <!--begin::Marked-->
                                                <span class="menu-link @if($formId==$id) active @endif">
                                                    <span class="menu-icon">
                                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs009.svg-->
                                                        <span class="svg-icon svg-icon-6 svg-icon-success me-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 6C8.7 6 6 8.7 6 12C6 15.3 8.7 18 12 18C15.3 18 18 15.3 18 12C18 8.7 15.3 6 12 6Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <span class="menu-title fw-bolder">{{ $formName }}</span>
                                                </span>
                                                <!--end::Marked-->
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                                <!--end::Menu item-->                                
                            </div>
                            <!--end::Menu-->                         
                        </div>
                        <!--end::Aside content-->
                    </div>
                    <!--end::Sticky aside-->
                </div>
                <!--end::Sidebar-->

                
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                    <!--begin::Card-->
                    <div class="card">

                        <div class="card-header align-items-center py-5 gap-5">
                            <!--begin::Actions-->
                            <div class="d-flex">
                                <h2 class="fw-bold me-3 my-1">{{ $visit->name }}</h2>
                            </div>
                            <!--end::Actions-->
                            <!--begin::Right-->
                            {{-- <div class="d-flex align-items-center"></div> --}}
                            <!--end::Right-->
                        </div>

                        <div class="card-body">
                          @if(!$formId) @include('visits.visit_overview') @else @include('visits.form') @endif                      
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Inbox App - View & Reply -->
        </div>
        <!--end::Container-->
    </div>    
</x-app-layout>
