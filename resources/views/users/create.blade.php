<x-app-layout>
    @slot('title')
        Create New User
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New User For Company: {{ $currentCompany }}
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'users.index',
                        '<i class="la la-list"></i> Users List',
                        auth()->user()->company_id == $companyId ? null : $companyId,
                        ['class' => 'btn btn-sm btn-light'],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">

            <x-tab-comp :lists="$lists"></x-tab-comp>

            <div class="card-body p-lg-15" x-data>

                {{ Form::model(request()->old(), [
                    'route' => ['companies.users.store', $companyId],
                    'class' => 'form',
                    'novalidate' => 'novalidate',
                    'method' => 'POST',
                    'files' => true,
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

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

                    <div class="col-md-6 fv-row">
                        {{ Form::label('mobile', 'Mobile', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::text('mobile', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('mobile') ? ' is-invalid' : null),
                            'placeholder' => 'Enter User Mobile',
                            'required' => 'required',
                        ]) }}

                        @error('mobile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('email', 'Email', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::text('email', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('email') ? ' is-invalid' : null),
                            'placeholder' => 'Enter User Email',
                            'required' => 'required',
                        ]) }}

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('password', 'Password', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                        {{ Form::password('password', [
                            'class' => 'form-control form-control-solid' . ($errors->has('password') ? ' is-invalid' : null),
                            'placeholder' => 'Enter User Password',
                            'required' => 'required',
                        ]) }}

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="row g-9 mb-8">

                    <div class="col-md-6 fv-row">
                        {{ Form::label('code', 'Code (Valid User ID)', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::text('code', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('code') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Valid User ID',
                            'required' => 'required',
                        ]) }}

                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('role_id', 'Role', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::select('role_id', $roles, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('role_id') ? ' is-invalid' : null),
                            'placeholder' => 'Select Role',
                            'data-control' => 'select2',
                            'required' => 'required',
                        ]) }}

                        @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">

                    <div class="col-md-6 fv-row">
                        {{ Form::label('avatar', 'Upload Avatar', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::file('avatar', ['class' => 'form-control form-control-solid' . ($errors->has('avatar') ? ' is-invalid' : null)]) }}

                        @error('avatar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('supervisor_id', 'Supervisor', ['class' => 'fs-6 fw-bold mb-2']) }}

                        {{ Form::select('supervisor_id', $supervisors, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('supervisor_id') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'placeholder' => 'Select a Supervisor',
                        ]) }}

                        @error('supervisor_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="row g-9 mb-8">

                    <div class="col-md-6 fv-row">
                        {{ Form::label('department_id', 'Department', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::select('department_id', $departments, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('department_id') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'placeholder' => 'Select Department',
                            'required' => 'required',
                        ]) }}

                        {{-- <select
                            name="department_id"
                            id="department_id"
                            class="form-select form-select-solid {{ ($errors->has('department_id') ? ' is-invalid' : null) }}"
                            x-model="department_id"
                        >
                            <option value="">Select Department</option>
                            <template x-for="department in departments">
                                <option :value="department.id" x-text="department.name"></option>
                            </template>
                        </select> --}}

                        @error('department_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('designation_id', 'Designation', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::select('designation_id', $designations, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('designation_id') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'placeholder' => 'Select a Designation',
                            'required' => 'required',
                        ]) }}

                        @error('designation_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('zone', 'Zone', ['class' => 'fs-6 fw-bold mb-2']) }}

                        {{ Form::select('zone_ids[]', $zones, null, [
                            'id' => 'zone',
                            'class' => 'form-select form-select-solid' . ($errors->has('status') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'multiple' => 'multiple',
                        ]) }}

                        @error('zone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::select('status', App\Enum\Status::array(), App\Enum\Status::Active->value, [
                            'class' => 'form-select form-select-solid' . ($errors->has('status') ? ' is-invalid' : null),
                            'placeholder' => 'Select Status',
                            'data-control' => 'select2',
                            'required' => 'required',
                        ]) }}

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                @if (auth()->user()->isAdministrator())
                    <div class="fv-row mb-5">
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input name="email_verified_at" class="form-check-input h-20px w-20px"
                                        type="checkbox" value="{{ now() }}" />
                                    <span class="form-check-label fw-bold">With Verify Email Address</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($otherCompanies->count())
                    <div class="mb-7 text-center">
                        <h1 class="mb-3">Other Companies</h1>
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

                    <div class="mb-15 fv-row">
                        <div class="d-flex align-items-center js-action-wraper" style="padding: 10px;">
                            @foreach ($otherCompanies as $key => $element)
                                <div class="js-actions">
                                    <label class="form-check form-check-custom form-check-solid me-10">
                                        <input id="checkoruncheck" class="form-check-input h-20px w-20px child"
                                            type="checkbox" name="company_ids[]" value="{{ $key }}"
                                            onchange="checkUncheckAll(this)" style="margin-bottom: 5px;" />
                                        <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                            {{ $element }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
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

    @push('scripts')
        <script>
            // For zone multi-select boxes
            $(document).ready(function() {
                $('#zone').select2({
                    placeholder: 'Select Zone'
                });
            });
        </script>
        <script>
            $(document).ready(function(e) {
                $("#checkoruncheck").change(function() {
                    $("input:checkbox").prop('checked', $(this).prop("checked"));
                });
            });

            function checkUncheckAll(selector) {
                let hasCheckedAny = false;
                if ($(selector).is(':checked') === true) {
                    hasCheckedAny = true;
                } else {
                    $.each($('.child'), function(ind, val) {
                        if ($(this).is(':checked') === true) {
                            hasCheckedAny = true;
                        }
                    });
                }
                $("#checkoruncheck").prop('checked', hasCheckedAny);
            }
        </script>
    @endpush
</x-app-layout>
