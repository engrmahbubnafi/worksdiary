<x-app-layout>
    @slot('title')
        Add Source Detail
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New Source Details for {{ $source->name }}
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'sources.index',
                        '<i class="fa fa-list"></i> Source List',
                        auth()->user()->company_id != $source->company_id ? $source->company_id : null,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}

                {!! Html::decode(
                    link_to_route('sources.source-details.index', '<i class="fa fa-list"></i> Source Details', $source, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
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

                {{ Form::model(request()->old(), [
                    'route' => ['sources.source-details.store', $source],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('from', 'From', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2']) }}

                        {{ Form::text('from', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('from') ? ' is-invalid' : null),
                            'placeholder' => 'From',
                        ]) }}

                        @error('from')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('to', 'To', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2']) }}

                        {{ Form::text('to', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('to') ? ' is-invalid' : null),
                            'placeholder' => 'To',
                        ]) }}

                        @error('to')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('value', 'Value', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                        {{ Form::text('value', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('value') ? ' is-invalid' : null),
                            'placeholder' => 'Value',
                            'required' => 'required',
                        ]) }}

                        @error('value')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('is_default', 'Default', ['class' => 'required fs-6 fw-bold mb-2']) }}

                        {{ Form::select('is_default', config('conf.is_default'), null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('is_default') ? ' is-invalid' : null),
                            'data-placeholder' => 'Select if Default',
                            'required' => 'required',
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                        ]) }}

                        @error('is_default')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', ['class' => 'required fs-6 fw-bold mb-2']) }}

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
