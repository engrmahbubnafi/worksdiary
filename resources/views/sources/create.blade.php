<x-app-layout>
    @slot('title')
        New Source
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New Source for "{{ $currentCompany?->title }}"
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'sources.index',
                        '<i class="fa fa-list"></i> Sources List',
                        auth()->user()->company_id == $companyId ? null : $companyId,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">

            <x-tab-comp :lists="$lists"></x-tab-comp>

            <div class="card-body p-lg-15">

                {{ Form::model(request()->old(), [
                    'route' => ['companies.sources.store', $companyId],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Source Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                        {{ Form::text('name', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Source Name',
                            'required' => 'required',
                        ]) }}

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('unit_type_id', 'Unit Type', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::select('unit_type_id', $unitTypes, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('unit_type_id') ? ' is-invalid' : null),
                            'placeholder' => 'Select Unit Type',
                            'required' => 'required',
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                        ]) }}

                        @error('unit_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
</x-app-layout>
