<x-app-layout>
    @slot('title')
        Create New Area
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Create area for Zone: "{{ $zone->name }}" and Company: "{{ $company->name }}"
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'zones.index',
                        '<i class="fa fa-list"></i> Zone List',
                        auth()->user()->company_id != $company->id ? $company->id : null,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}

                {!! Html::decode(
                    link_to_route(
                        'companies.zones.areas.index',
                        'Area List',
                        [$company->id, $zone->id],
                        ['class' => 'btn btn-sm btn-light'],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model(request()->old(), [
                    'route' => ['companies.zones.areas.store', [$company->id, $zone->id]],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Area Name', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('name', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'required' => 'required',
                            'placeholder' => 'Enter Area Name',
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
