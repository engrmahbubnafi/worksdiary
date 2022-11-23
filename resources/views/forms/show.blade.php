<x-app-layout>
    @slot('title')
        Forms
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Forms
            @slot('actions')
                <!-- Form Lists Button -->
                {!! Html::decode(
                    link_to_route(
                        'forms.index',
                        '<i class="fa fa-list"></i> Form Lists',
                        [$form->company_id, $form->id],
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}
                <!-- Form Lists Button -->

                <!-- Add Field Button -->
                {!! Html::decode(
                    link_to_route('forms.fields.create', '<i class="fa fa-plus"></i> Add Field', $form->id, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
                <!-- Add Field Button -->

                <!-- Clone Form Button -->
                {!! Html::decode(
                    link_to_route('forms.clone', '<i class="fa fa-copy"></i> Clone Form', $form->id, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
                <!-- Clone Form Button -->
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin::Products-->
                <div class="card card-flush mb-5 mb-xl-8">

                    <!--begin::FormHeader-->
                    <div class="card-px text-center py-10">
                        <!--begin::Title-->
                        <h2 class="fs-2x fw-bolder mb-4">{{ $form->name }}</h2>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <p class="text-gray-400 fs-4 fw-bold mb-5">Unit (Shop/Farm/Ponds) name , its address
                            <br />and dealer's name (if needed) will be visible hare in app view.
                        </p>
                        <!--end::Description-->
                    </div>
                    <!--end::FormHeader-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Form-->

                        @forelse($fields as $key => $fieldArr)

                            @if ($key)
                                <h2 class="mb-5">{{ $key }}</h2>
                            @endif

                            @foreach ($fieldArr as $field)
                                <!--begin::Input group-->
                                <div class="row fv-row mb-7">
                                    <div class="col-md-3">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span>{{ $field->name }}</span>
                                            {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Show the number of products inside the subcategories in the storefront header category menu. Be warned, this will cause an extreme performance hit for stores with a lot of subcategories!"></i> --}}
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <div class="col-md-9">
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid"
                                            name="products_items_per_page" readonly />
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            @endforeach

                            {{-- <div class="separator my-5"></div> --}}

                        @empty
                            <div class="text-danger text-center">
                                No fields added yet.
                            </div>
                        @endforelse

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Container-->
    </div>

</x-app-layout>
