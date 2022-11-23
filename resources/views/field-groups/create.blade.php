<x-app-layout>
    @slot('title')
        Create New Field Group
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Create New Field Group
            @slot('actions')
                {!! Html::decode(link_to_route('field-groups.index', 'Field Groups', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">

                {{ Form::model(request()->old(), [
                    'route' => 'field-groups.store',
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Field Group Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                        {{ Form::text('name', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Field Group Name',
                        ]) }}

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('form_id', 'Form Name', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::select('form_id', $forms, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('form_id') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'required' => 'required',
                            'placeholder' => 'Select Form',
                        ]) }}

                        @error('form_id')
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
