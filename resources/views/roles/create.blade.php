<x-app-layout>
    @slot('title')
        New Role
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New Role
            @slot('actions')
                {!! Html::decode(link_to_route('roles.index', 'Role List', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model(request()->old(), [
                    'route' => 'roles.store',
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="d-flex flex-column fv-row mb-8">
                    {{ Form::label('name', 'Role Name', [
                        'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                    ]) }}

                    {{ Form::text('name', null, [
                        'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                        'placeholder' => 'Enter Role Name',
                    ]) }}

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('description', 'Description', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::text('description', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('description') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Role Description',
                        ]) }}

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::select('status', App\Enum\Status::array(), App\Enum\Status::Active->value, [
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

                @if (auth()->user()->isAdministrator())
                    <div class="mb-15 fv-row">
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center">
                                {{-- {{ Form::checkbox('is_editable', 1, true, [
                                    'id' => 'checkboxCustom3',
                                    'class' => 'form-check-input h-20px w-20px form-check-label fw-bold',
                                ]) }}

                                {{ Form::label('is_editable', 'Editable', [
                                    'class' => 'form-check form-check-custom form-check-solid me-10',
                                ]) }}

                                {{ Form::checkbox('is_deletable', 1, true, [
                                    'id' => 'checkboxCustom3',
                                    'class' => 'form-check-input h-20px w-20px',
                                ]) }}

                                {{ Form::label('is_editable', 'Deletable', [
                                    'class' => 'form-check form-check-custom form-check-solid form-check-label fw-bold me-10',
                                ]) }} --}}

                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input id="checkboxCustom3" class="form-check-input h-20px w-20px" type="checkbox"
                                        name="is_editable" value="1" checked="checked" />
                                    <span class="form-check-label fw-bold">Editable?</span>
                                </label>

                                @error('is_editable')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror



                                <label class="form-check form-check-custom form-check-solid">
                                    <input id="checkboxCustom3" class="form-check-input h-20px w-20px" type="checkbox"
                                        name="is_deletable" value="1" checked="checked" />
                                    <span class="form-check-label fw-bold">Deletable?</span>
                                </label>
                                @error('is_deletable')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                @php
                    $controllersArray = array_chunk($permission, 4, true);
                @endphp

                <div class="mb-7 text-center">
                    <h1 class="mb-3">Permission Settings</h1>
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

                @foreach ($controllersArray as $elements)
                    <div class="mb-15 fv-row">
                        @foreach ($elements as $key => $elements)
                            <div class="d-flex align-items-center js-controller">
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input id="checkoruncheck"
                                        class="form-check-input h-20px w-20px js-parent-{{ $key }}"
                                        type="checkbox" checked="checked" name="permission_ids[]"
                                        value="{{ array_search($key, $parents) }}"
                                        onchange="permissionSelectDeselectChild(this)" style="margin-bottom: 5px;" />
                                    <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                        {{ Str::replace('Controller', 'Management', Str::camelToSpace($key)) }}
                                    </span>
                                </label>
                            </div>

                            <div class="d-flex align-items-center js-action-wraper" style="padding: 10px;">
                                @foreach ($elements as $key2 => $element)
                                    <div class="js-actions">
                                        @if (array_key_exists($element, $custom_action_arr))
                                            <label class="form-check form-check-custom form-check-solid me-10">
                                                <input id="checkoruncheck"
                                                    class="form-check-input h-20px w-20px {{ $key }}"
                                                    type="checkbox" checked="checked" name="permission_ids[]"
                                                    value="{{ array_search($key, $parents) }}"
                                                    onchange="permissionSelectParent('{{ $key }}')"
                                                    style="margin-bottom: 5px;" />
                                                <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                                    {{ $custom_action_arr[$element] }}
                                                </span>
                                            </label>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach

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
                    $("input:checkbox").not('#checkboxCustom3').prop('checked', $(this).prop("checked"));
                });
            });

            function permissionSelectDeselectChild(selector) {
                let check;

                if ($(selector).is(':checked') === false) {
                    check = false;
                } else {
                    check = true;
                }

                if ($(selector).parent().parent().hasClass('js-controller') === true) {
                    var action_ul = $(selector).parent().parent().next('div.js-action-wraper');
                    $.each(action_ul.children('.js-actions'), function(ind, val) {
                        var cur_check_box = $(val).children().children('input');
                        $(cur_check_box).prop('checked', check);
                    });
                }
            }

            function permissionSelectParent(selector) {
                let check = $('.' + selector).is(':checked');

                $('.js-parent-' + selector).prop('checked', check);
            }
        </script>
    @endpush
</x-app-layout>
