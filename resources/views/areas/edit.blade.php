<x-app-layout>
    @slot('title')
        Edit Area
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit area for  Zone: "{{ $zone->name  }}" and Company: "{{ $company->name }}"
            @slot('actions')
                {!! Html::decode(
                    link_to_route('companies.zones.areas.index', 'Area List', [$company->id,$zone->id], ['class' => 'btn btn-sm btn-light']),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model($area, [
                    'route' => ['companies.zones.areas.update', [$company->id,$zone->id, $area->id]],
                    'class' => 'form',
                    'method' => 'PUT',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Area Name', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('name', $area->name, [
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
</x-app-layout>
