<x-app-layout>
    @slot('title')
        Edit Form
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Form
            @slot('actions')
                {!! Html::decode(link_to_route('forms.index', 'Forms', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">

                {{ Form::model($form, [
                    'route' => ['companies.forms.update', [$form->company_id, $form->id]],
                    'class' => 'form',
                    'method' => 'PUT',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Name', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('name', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Name',
                            'required' => 'required',
                        ]) }}

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 fv-row">
                        {{ Form::label('is_multiple', 'Multiple', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::select('is_multiple', config('conf.is_multiple'), null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('is_multiple') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'required' => 'required',
                        ]) }}

                        @error('is_multiple')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('unit_type', 'Unit Type', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::select('unit_type_id', $unitTypes, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('unit_type_id') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'required' => 'required',
                        ]) }}

                        @error('unit_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('number_of_fields', 'Number of Fields', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('number_of_fields', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('number_of_fields') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Number of Fields',
                            'required' => 'required',
                        ]) }}

                        @error('number_of_fields')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('time_duration', 'Time Duration Unit', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::select('time_duration_unit', config('conf.time_duration_unit'), null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('time_duration_unit') ? ' is-invalid' : null),
                            'data-control' => 'select2',
                            'data-hide-search' => 'true',
                            'required' => 'required',
                        ]) }}

                        @error('time_duration_unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
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
                <div class="row g-9 mb-8">                  
                    <div class="col-md-6 fv-row">                       

                        <label for="is_skippable" class = 'align-items-center fs-6 fw-bold mb-2'>
                            {{ Form::checkbox('is_skippable', 1, null, [
                                'class' => 'form-check-input h-20px w-20px',
                                'id'=>'is_skippable'
                            ]) }}
                            Is Skippable
                        </label> 

                        @error('is_skippable')
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
