<x-app-layout>
    @slot('title')
        Clone Role
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Clone Role
            @slot('actions')
                {!! Html::decode(link_to_route('roles.index', 'Role List', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">

                {{ Form::model($role, [
                    'route' => ['roles.clone', $role->id],
                    'class' => 'form',
                    'method' => 'PUT',
                ]) }}

                <div class="d-flex flex-column fv-row mb-8">
                    {{ Form::label('name', 'Role Name', [
                        'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                    ]) }}

                    {{ Form::text('name', $role->name.'_copy', [
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

                        {{ Form::text('description', $role->description.'_copy', [
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

                @if (auth()->user()->isAdministrator())
                    <div class="mb-15 fv-row">
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input id="checkboxCustom3" class="form-check-input h-20px w-20px" type="checkbox"
                                        name="is_editable" @checked($role->is_editable == 1) />
                                    <span class="form-check-label fw-bold">Editable?</span>
                                </label>
                                @error('is_editable')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label class="form-check form-check-custom form-check-solid">
                                    <input id="checkboxCustom3" class="form-check-input h-20px w-20px" type="checkbox"
                                        name="is_deletable" @checked($role->is_deletable == 1) />
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
                        $chunkedArr = $permissions->chunk(4);
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

                    @foreach ($chunkedArr as $chunkObj)
                        <div class="mb-15 fv-row">
                            @foreach ($chunkObj as $key => $parentsObj)
                                <div class="d-flex align-items-center js-controller">
                                    <label class="form-check form-check-custom form-check-solid me-10">
                                        <input id="checkoruncheck"
                                            class="form-check-input h-20px w-20px js-parent-{{ $key }}"
                                            type="checkbox" @if($ownPermissions->has($parentsObj->id)) checked="checked" @endif name="permission_ids[]"
                                            value="{{ $parentsObj->id }}"
                                            onchange="permissionSelectDeselectChild(this)" style="margin-bottom: 5px;" />
                                        <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                            {{ str()->of($parentsObj->name)->replace('Controller', 'Management')->kebab()->title() }}
                                        </span>
                                    </label>
                                </div>

                                @if($parentsObj->children->count())
                                    <div class="d-flex align-items-center js-action-wraper" style="padding: 10px;">
                                        @foreach ($parentsObj->children as $key2 => $childObj)
                                            @php
                                                if($custom_action_arr->has($childObj->name)){
                                                    $customActionObj=$custom_action_arr->get($childObj->name);
                                                    $class=$customActionObj->class;
                                                    $link=$customActionObj->link;
                                                    $actionName= $customActionObj->title;
                                                }else{
                                                    $actionName=$childObj->name;
                                                    $class=null;
                                                    $link=null;
                                                }
                                            @endphp

                                            <div class="js-actions {{ $class }}">
                                                <label class="form-check form-check-custom form-check-solid me-10">
                                                    <input id="checkoruncheck"
                                                        class="form-check-input h-20px w-20px {{ $key }} {{ $childObj->name }}"
                                                        type="checkbox" @if($ownPermissions->has($childObj->id)) checked="checked" @endif name="permission_ids[]"
                                                        value="{{ $childObj->id }}"
                                                        onchange="permissionSelectParent('{{ $key }}'), togetherSelect(this,'{{ $link }}')"
                                                        style="margin-bottom: 5px;" />
                                                    <span class="form-check-label fw-bold" style="padding-bottom: 5px;">
                                                        {{  str()->of($actionName)->kebab()->title() }}
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach

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
            $(document).ready(function(e) {
                $("#checkoruncheck").change(function() {
                    $("input:checkbox").not('#checkboxCustom3').prop('checked', $(this).prop("checked"));
                });
            });

            //when click on controller button
            function permissionSelectDeselectChild(selector) {
                let check;

                if ($(selector).is(':checked') === false) {
                    check = false;
                } else {
                    check = true;
                }

                var action_ul = $(selector).parents('.js-controller').next('div.js-action-wraper');
                $.each(action_ul.children('.js-actions'), function(ind, val) {
                    var cur_check_box = $(val).find('input');
                    $(cur_check_box).prop('checked', check);
                });
            }

            //when click on actions button
            function permissionSelectParent(selector) {
                let check = $('.' + selector).is(':checked');
                $('.js-parent-' + selector).prop('checked', check);
            }

            function togetherSelect(selector,toWhom){
                if(toWhom && toWhom.length){
                    let tis=$(selector);
                    let checked=tis.is(':checked');
                    let parents=tis.parents('div.js-action-wraper').find('.'+toWhom).prop('checked', checked);
                }
            }
        </script>
    @endpush
</x-app-layout>
