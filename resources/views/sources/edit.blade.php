<x-app-layout>
    @slot('title')
        Edit Source
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Source
            @slot('actions')
                {!! Html::decode(
                    link_to_route('sources.source-details.index', 'Source Details', $source->id, ['class' => 'btn btn-sm btn-light']),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ Form::model($source, [
                    'route' => ['companies.sources.update', [$source->company_id, $source->id]],
                    'class' => 'form',
                    'method' => 'PUT',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Source Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                        {{ Form::text('name', $source->name, [
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

                        {{ Form::select('unit_type_id', $unitTypes, $source->unit_type_id, [
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

                <div class="row g-9 mb-8">

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
