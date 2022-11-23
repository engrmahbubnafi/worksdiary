<x-app-layout>
    @slot('title')
        Create New Zone
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New Zone For "{{ $currentCompany?->title }}"
            @slot('actions')
                {!! Html::decode(link_to_route('zones.index', 'Zones List', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">

            <x-tab-comp :lists="$lists"></x-tab-comp>

            <div class="card-body p-lg-15">
                {{ Form::model(request()->old(), [
                    'route' => ['companies.zones.store',$companyId],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="row g-9 mb-8">             

                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Zone Name', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('name', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'required' => 'required',
                            'placeholder' => 'Enter Zone Name',
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
