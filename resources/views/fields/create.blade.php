<x-app-layout>
    @slot('title')
        Create Field
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Create Field for {{ $formName }}
            @slot('actions')
                <!-- Form View Button -->
                {!! Html::decode(
                    link_to_route(
                        'companies.forms.show',
                        '<i class="fa fa-list"></i> Form View',
                        [auth()->user()->company_id == $companyId ? null : $companyId, $formId],
                        ['class' => 'btn btn-sm btn-light'],
                    ),
                ) !!}
                <!-- Form View Button -->

                <!-- Form List -->
                {!! Html::decode(
                    link_to_route(
                        'forms.index',
                        '<i class="fa fa-list"></i> Form List',
                        auth()->user()->company_id != $companyId ? $companyId : null,
                        ['class' => 'btn btn-sm btn-light'],
                    ),
                ) !!}
                <!-- Form List -->

                <!-- All Fields Button -->
                {!! Html::decode(
                    link_to_route('forms.fields.index', '<i class="fa fa-list"></i> All Fields', $formId, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
                <!-- All Fields Button -->
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl" x-data="referenceObj">
        <div class="card">
            <div class="card-body p-lg-15">

                {{ Form::model(request()->old(), [
                    'route' => ['forms.fields.store', $formId],
                    'class' => 'form repeater',
                    'method' => 'POST',
                ]) }}

                {{ Form::hidden('form_id', $formId) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-12 fv-row">
                        {{ Form::label('name', 'Name', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('name', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Name',
                            'required' => 'required',
                        ]) }}

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">

                        <label for="field_group_id"
                            class="d-flex align-items-center fs-6 fw-bold mb-2 justify-content-between">
                            <span>Field Group</span>

                            <button type="button" class="btn btn-icon btn-sm btn-success me-2"
                                x-on:click="showModal()">
                                <i class="fa fa-2x fa-plus"></i>
                            </button>

                        </label>

                        {{ Form::select('field_group_id', $fieldGroup, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('field_group_id') ? ' is-invalid' : null),
                            'placeholder' => 'Select Field Group',
                            'id' => 'field_group_id',
                            'data-control' => 'select2',
                        ]) }}

                        @error('field_group_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('field_type_id', 'Field Type', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::select('field_type_id', $fieldType, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('field_type_id') ? ' is-invalid' : null),
                            'placeholder' => 'Select Field Type',
                            'required' => 'required',
                            'data-control' => 'select2',
                        ]) }}

                        @error('field_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('length', 'Length', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('length', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('length') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Length',
                            'required' => 'required',
                        ]) }}

                        @error('length')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 fv-row">
                        {{ Form::label('compare_value', 'Compare Field', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2',
                        ]) }}

                        {{-- <div x-html="compare"></div> --}}
                        {{ Form::select('compare_value', $compareValues, null, [
                            'class' => 'form-select form-select-solid',
                            'placeholder' => 'Select Compare Value',
                            'data-control' => 'select2',
                        ]) }}

                    </div>

                </div>


                <div class="row g-9 mb-8">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 fv-row mt-12">
                                <label class="form-check form-check-custom form-check-solid">
                                    {{ Form::checkbox('is_required', 1, null, [
                                        'class' => 'form-check-input h-20px w-20px',
                                    ]) }}
                                    <span class="form-check-label fw-bold">Is Required?</span>
                                </label>
                            </div>
                            <div class="col-md-6 fv-row mt-12">
                                <label class="form-check form-check-custom form-check-solid">
                                    {{ Form::checkbox('is_reportable', 1, null, [
                                        'class' => 'form-check-input h-20px w-20px',
                                    ]) }}
                                    <span class="form-check-label fw-bold">Is Reportable?</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8 fv-row">
                                {{ Form::label('reference_value', 'Reference Field', [
                                    'class' => 'd-flex align-items-center fs-6 fw-bold mb-2',
                                ]) }}
                                <div class="col-md-12 fv-row">
                                    {{ Form::select('reference_value', $referenceValues, null, [
                                        'class' => 'form-select form-select-solid',
                                        'placeholder' => 'Select Reference Value',
                                        'data-control' => 'select2',
                                    ]) }}

                                </div>

                            </div>

                            <div class="col-md-4 fv-row mt-12">
                                <label class="form-check form-check-custom form-check-solid">
                                    {{ Form::checkbox('is_formula', true, null, [
                                        'class' => 'form-check-input h-20px w-20px',
                                        'x-model' => 'isFormula',
                                        'id' => 'is_formula',
                                    ]) }}
                                    <span class="form-check-label fw-bold">Is Formula?</span>
                                </label>
                            </div>

                        </div>
                        <div class="col-md-12 fv-row mt-12">
                            @php
                                $type = [
                                    'string' => 'String',
                                    'id' => 'ID',
                                    'number' => 'Number',
                                ];
                            @endphp
                            <template x-if="isFormula">
                                <div>
                                    <div data-repeater-list="formula" class="pb-3">
                                        @if (old('formula') && count(old('formula')))
                                            @foreach (old('formula') as $key => $val)
                                                <div class="row pb-3" data-repeater-item>
                                                    <div class="col-md-6 fv-row">
                                                        {{ Form::select('type', $type, $val['type'], [
                                                            'class' => 'form-select form-select-solid',
                                                            'placeholder' => 'Select type',
                                                        ]) }}
                                                    </div>
                                                    <div class="col-md-3 fv-row">
                                                        {{ Form::text('value', $val['value'], [
                                                            'class' => 'form-control form-control-solid',
                                                            'placeholder' => '',
                                                        ]) }}
                                                    </div>
                                                    <div class="col-md-3 fv-row">
                                                        <input data-repeater-delete class="btn btn-danger"
                                                            type="button" value="Delete" />
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row pb-3" data-repeater-item>
                                                <div class="col-md-6 fv-row">
                                                    {{ Form::select('type', $type, null, [
                                                        'class' => 'form-select form-select-solid',
                                                        'placeholder' => 'Select type',
                                                    ]) }}
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    {{ Form::text('value', null, [
                                                        'class' => 'form-control form-control-solid',
                                                        'placeholder' => '',
                                                    ]) }}
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    <input data-repeater-delete class="btn btn-danger" type="button"
                                                        value="Delete" />
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <input class="btn btn-info" data-repeater-create type="button" value="Add" />
                                </div>
                            </template>

                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm ms-2 align-middle"></span>
                    </span>
                </button>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <x-modals.master-modal :form-attr="['route' => ['forms.field-groups.store', $formId], 'id' => 'groups']">
        @slot('title')
            Create a field group
        @endslot

        {{ Form::model(request()->old(), [
            'route' => ['forms.field-groups.store', [$formId]],
            'class' => 'form',
            'method' => 'POST',
        ]) }}

        <div class="row g-9 mb-8">
            <div class="col-md-6 fv-row">
                {{ Form::label('name', 'Field Group Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                {{ Form::text('name', null, [
                    'class' => 'form-control form-control-solid' . ($errors->groups->has('name') ? ' is-invalid' : null),
                    'placeholder' => 'Enter Field Group Name',
                    'required' => 'required',
                ]) }}

                @if ($errors->groups->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->groups->first('name') }}
                    </div>
                @endif
            </div>

            <div class="col-md-6 fv-row">
                {{ Form::label('status', 'Status', [
                    'class' => 'required fs-6 fw-bold mb-2',
                ]) }}

                {{ Form::select('status', App\Enum\Status::array(), App\Enum\Status::Active->value, [
                    'class' => 'form-select form-select-solid' . ($errors->groups->has('status') ? ' is-invalid' : null),
                    'placeholder' => 'Select Status',
                    'data-control' => 'select2',
                    'data-hide-search' => 'true',
                    'required' => 'required',
                ]) }}

                @if ($errors->groups->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->groups->first('status') }}
                    </div>
                @endif
            </div>
        </div>

        @slot('actions')
            {{ Form::submit('Confirm', ['class' => 'btn btn-primary']) }}
        @endslot
    </x-modals.master-modal>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('referenceObj', () => ({
                    isFormula: false,
                    init() {

                        this.$watch('isFormula', value => {
                            if (value) {
                                $('.repeater').repeater();
                            }
                        })

                        @if (old('is_formula'))
                            this.isFormula = true
                        @endif

                        @if ($errors->groups->any())
                            this.showModal();
                        @endif
                    },
                    showModal() {
                        var myModal = new bootstrap.Modal(document.getElementById('bb-modal'));
                        myModal.show();
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>
