<x-app-layout>
    @slot('title')
        Edit Company
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Company
            @slot('actions')
                {!! Html::decode(link_to_route('companies.index', 'Companies List', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model($company, [
                    'route' => ['companies.update', $company->id],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}
                @method('PATCH')
                @csrf
                <div class="d-flex flex-column fv-row mb-8">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="required">Company Name</span>
                    </label>
                    {{ Form::text('name', null, [
                        'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                        'required' => 'required',
                        'placeholder' => 'Enter Company Name',
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
                            'placeholder' => 'Enter Company Code',
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
                    <div class="d-flex flex-column fv-row mb-8">
                        <label class="fs-6 fw-bold mb-2">Address</label>
                        {{ Form::textarea('address', null, [
                            'class' => 'form-control form-control-solid',
                            'rows' => 3,
                            'placeholder' => 'Enter Company address',
                        ]) }}

                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm ms-2 align-middle"></span>
                        </span>
                    </button>
                </div>
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
