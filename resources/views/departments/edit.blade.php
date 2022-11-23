<x-app-layout>
    @slot('title')
        Edit Department
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Department For Company::{{ $currentCompany }}
            @slot('actions')
                {!! Html::decode(
                    link_to_route('departments.index', 'Departments List', null, ['class' => 'btn btn-sm btn-light']),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model($department, [
                    'route' => ['companies.departments.update', [$department->company_id,$department->id]],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                @method('PATCH')     

                @csrf

                <div class="d-flex flex-column fv-row mb-8">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="required">Department Name</span>
                    </label>
                    {{ Form::text('name', null, [
                        'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                        'required' => 'required',
                        'placeholder' => 'Enter Department Name',
                    ]) }}
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Code</label>
                        {{ Form::text('code', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('code') ? ' is-invalid' : null),
                            'required' => 'required',
                            'placeholder' => 'Enter department Code',
                        ]) }}
                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

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
                </div>

                @if($unitTypes->count())
                    <section class="row mt-15">
                        <div class="mb-7 text-center">
                            <h1 class="mb-3">Select unit types for this department</h1>
                        </div>
                        <div class="fv-row mb-5">
                            <div class="d-flex flex-stack">
                                <div class="d-flex align-items-center">
                                    <label class="form-check form-check-custom form-check-solid me-10">
                                        <input id="checkoruncheck" class="form-check-input h-20px w-20px" type="checkbox" />
                                        <span class="form-check-label fw-bold">Check/Uncheck All</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-10 fv-row">
                            @foreach ($unitTypes as $value)
                            <div class="d-flex align-items-center js-controller">
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input id="checkoruncheck" class="form-check-input h-20px w-20px department"
                                    type="checkbox" @if($selectedUnitTypes->has($value->id)) checked="checked" @endif name="type_ids[]"
                                    value="{{ $value->id }}"
                                    style="margin-bottom: 5px;" />
                                    <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                            {{ $value->name}}
                                    </span>
                                </label>
                            </div>
                            

                            <div class="d-flex align-items-center js-action-wraper pt-3" style=" padding-left: 20px;border-top:1px solid #ddd;">
                                @foreach ($value->children as $child)
                                    <div class="js-actions pb-5">
                                        <label class="form-check form-check-custom form-check-solid me-10">
                                            <input id="checkoruncheck" class="form-check-input h-20px w-20px department"
                                                type="checkbox"  @if($selectedUnitTypes->has($child->id)) checked="checked" @endif name="type_ids[]"
                                                value="{{ $child->id }}"
                                                style="margin-bottom: 5px;" />
                                            <span class="form-check-label" style="padding-bottom: 5px;">
                                                {{ $child->name }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </section>
                @else
                    <div class="mb-7 text-center row mt-15">
                        <h1 class="mb-3">Unit type not available! please add unit type</h1>
                    </div>
                @endif 

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
</x-app-layout>
