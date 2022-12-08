<x-app-layout>
    @slot('title')
        Edit User
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit User For Company::{{ $currentCompany }}
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'companies.users.show',
                        'View Profile',
                        [$user->company_id, $user->id],
                        ['class' => 'btn btn-sm btn-light'],
                    ),
                ) !!}
                {!! Html::decode(link_to_route('users.index', 'Users List', null, ['class' => 'btn btn-sm btn-secondary'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl" x-data="user">
        <div class="card">
            <div class="card-body p-lg-15">

                {{ Form::model($user, [
                    'route' => ['companies.users.update', [$user->company_id, $user->id]],
                    'class' => 'form',
                    'novalidate' => 'novalidate',
                    'method' => 'PUT',
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
                        <label for="email"
                            class="d-flex align-items-center fs-6 fw-bold mb-2 justify-content-between">
                            <span>Email</span>
                        </label>

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
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <div class="row">
                            <div class="col-md-9">
                                {{ Form::label('avatar', 'Upload Avatar', ['class' => 'fs-6 fw-bold mb-2']) }}

                                {{ Form::file('avatar', ['class' => 'form-control form-control-solid' . ($errors->has('avatar') ? ' is-invalid' : null)]) }}

                                @error('avatar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-end h-100">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                            width="80" height="80">
                                    @else
                                        <span class="pb-3">
                                            No Avatar
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('password', 'Password', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2']) }}

                        {{ Form::password('password', [
                            'class' => 'form-control form-control-solid' . ($errors->has('password') ? ' is-invalid' : null),
                            'placeholder' => 'Enter User Password',
                        ]) }}

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                @if (auth()->user()->isAdministrator() || $user->id != auth()->id())
                    <div class="row g-9 mb-8">
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
                @else
                    <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                    <input type="hidden" name="supervisor_id" value="{{ $user->supervisor_id }}">
                @endif

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

                        {{ Form::select('zone_ids[]', $zones, $selectedUserZonesIds, [
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

                        {{ Form::select('status', App\Enum\Status::array(), null, [
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

                @if (auth()->user()->isAdministrator() && !$user->email_verified_at)
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
                                    <input id="checkoruncheck" class="form-check-input h-20px w-20px" type="checkbox"
                                        @if ($selectedOtherCompaniesForUser->count()) checked @endif />
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
                                            onchange="checkUncheckAll(this)" style="margin-bottom: 5px;"
                                            @if ($selectedOtherCompaniesForUser->has($key)) checked @endif />
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

                </form>
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
                    $("input:checkbox").not('#checkboxCustom3').prop('checked', $(this).prop("checked"));
                });
            });

            function permission_select_deselect_child(selector) {
                var check;
                if ($(selector).is(':checked') === false) {
                    check = false;
                } else {
                    check = true;
                }
                if ($(selector).parent().parent().hasClass('controller') === true) {
                    var action_ul = $(selector).parent().parent().next('div.action-wraper');
                    $.each(action_ul.children('.actions'), function(ind, val) {
                        var cur_check_box = $(val).children().children('input');
                        $(cur_check_box).prop('checked', check);
                    });
                }
            }

            function permission_select_parent(selector) {
                var check = $('.' + selector).is(':checked');
                $('.parent_' + selector).prop('checked', check);
            }
        </script>
    @endpush
</x-app-layout>
