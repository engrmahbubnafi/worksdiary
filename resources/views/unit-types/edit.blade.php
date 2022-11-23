<x-app-layout>
    @slot('title')
        Edit Unit Type
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Unit Type
            @slot('actions')
                {!! Html::decode(
                    link_to_route('unit-types.index', 'Unit Types', null, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">             

                {{ Form::model($unitType, [
                    'route' => ['unit-types.update', $unitType->id],
                    'method' => 'PUT',
                ]) }}

                <div class="d-flex flex-column fv-row mb-8">
                    <div class="row g-9 mb-8">
                        <div class="col-md-6 fv-row">
                            {{ Form::label('parent_id', 'Parent', [
                                'class' => 'fs-6 fw-bold mb-2',
                            ]) }}

                            {{ Form::select('parent_id',$parents , null, [
                                'class' => 'form-select form-select-solid' . ($errors->has('parent_id') ? ' is-invalid' : null),
                                'placeholder' => 'Select parent',
                                'data-control' => 'select2',
                                'data-hide-search' => 'true',
                            ]) }}

                            @error('parent_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 fv-row">
                            {{ Form::label('name', 'Unit Type Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                            {{ Form::text('name', null, [
                                'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                                'placeholder' => 'Enter Unit Type Name',
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
                            {{ Form::label('status', 'Status', [
                                'class' => 'required fs-6 fw-bold mb-2',
                            ]) }}

                            {{ Form::select('status', App\Enum\Status::array(), null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('status') ? ' is-invalid' : null),
                            'placeholder' => 'Select Status',
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'required' => 'required',
                        ]) }}

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 fv-row pt-12">
                            {{ Form::checkbox('is_slot_enabled',1, null, [
                                'id'=>'is_slot_enabled',
                                'class' => 'form-check-input h-20px w-20px'
                            ]) }}

                            {{ Form::label('is_slot_enabled', 'Is slot enabled', ['class' => 'align-items-center fs-6 fw-bold mb-2']) }}
                        </div>
                    </div>                
                </div>

                <div class="mb-7 text-center">
                    <h1 class="mb-3">Select department for this unit type</h1>
                </div>
                <div class="fv-row mb-5">
                    <div class="d-flex flex-stack">
                        <div class="d-flex align-items-center">
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input id="checkoruncheck" class="form-check-input h-20px w-20px" type="checkbox"
                                    checked="checked" />
                                <span class="form-check-label fw-bold">Check/Uncheck All</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-15 fv-row">
                    @foreach ($companyDepartments as $value)
                    <div class="d-flex align-items-center js-controller">
                        <label class="form-check form-check-custom form-check-solid me-10">

                            <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                {{ $value->name}}({{ $value->code  }})
                            </span>
                        </label>
                    </div>

                    <div class="d-flex align-items-center js-action-wraper" style="padding: 10px;border-top:1px solid #ddd;">
                        @foreach ($value->departments as $department)
                            <div class="js-actions">
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input id="checkoruncheck" class="form-check-input h-20px w-20px department"
                                        @if ($department_unit_types->search($department->id)) checked="checked" @endif type="checkbox"
                                        name="department_ids[]" value="{{ $department->id }}"
                                        style="margin-bottom: 5px;" />
                                    <span class="form-check-label" style="padding-bottom: 5px;">
                                        {{ $department->name }}
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endforeach
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
    @push('scripts')
        <script>
            $(document).ready(function(e) {
                $("#checkoruncheck").change(function() {
                    $("input:checkbox").not('#is_slot_enabled').prop('checked', $(this).prop("checked"));
                });
            });

            
        </script>
    @endpush
</x-app-layout>
