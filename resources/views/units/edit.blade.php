<x-app-layout>
    @slot('title')
        Edit Unit
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit {{ config('conf.unit') }}
            @slot('actions')
                {!! Html::decode(link_to_route('units.index', 'Units', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">               

                {{ Form::model($unit, [
                    'route' => ['units.update', $unit->id],
                    'class' => 'form',
                    'method' => 'PUT',
                ]) }}
               
                <x-unit-head-comp :unit="$unit"></x-unit-head-comp>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('owner', 'Owner Name', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::text('owner', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('owner') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Owner Name',
                            'required' => 'required',
                        ]) }}

                        @error('owner')
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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-8 fv-row">
                                {{ Form::label('address', 'Address', [
                                    'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                                ]) }}

                                {{ Form::textarea('address', null, [
                                    'class' => 'form-control form-control-solid' . ($errors->has('address') ? ' is-invalid' : null),
                                    'placeholder' => 'Enter Unit Address',
                                    'rows'=>4,
                                    'required' => 'required',
                                ]) }}

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 fv-row">
                                <label class="form-check form-check-custom form-check-solid">
                                    {{ Form::checkbox('as_dealer', 1, null, [
                                        'class' => 'form-check-input h-20px w-20px',
                                    ]) }}
                                    <span class="form-check-label fw-bold">Is Dealer Unit?</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 mb-8 fv-row">
                                {{ Form::label('latitude', 'Latitude', [
                                    'class' => 'd-flex align-items-center fs-6 fw-bold mb-2',
                                ]) }}
        
                                {{ Form::text('latitude', null, [
                                    'class' => 'form-control form-control-solid' . ($errors->has('latitude') ? ' is-invalid' : null),
                                    'placeholder' => 'Enter latitude',
                                ]) }}
        
                                @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
        
                            <div class="col-md-12 fv-row">
                                {{ Form::label('longitude', 'Longitude', [
                                    'class' => 'd-flex align-items-center fs-6 fw-bold mb-2',
                                ]) }}
        
                                {{ Form::text('longitude', null, [
                                    'class' => 'form-control form-control-solid' . ($errors->has('longitude') ? ' is-invalid' : null),
                                    'placeholder' => 'Enter longitude',
                                ]) }}
        
                                @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>                           
                        </div> 
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
