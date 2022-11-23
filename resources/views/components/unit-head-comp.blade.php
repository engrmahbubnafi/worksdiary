@php
    $selectedArr = $getSlectedArr();
@endphp
<section x-data="unitObj" x-init="select2Alpine">
    <div class="row g-9 mb-8">
        <div class="{{ $className }} fv-row">
            {{ Form::label('district_id', 'District', [
                'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
            ]) }}

            {{ Form::select('district_id', $districts, null, [
                'class' => 'form-select form-select-solid' . ($errors->has('district_id') ? ' is-invalid' : null),
                'placeholder' => 'Select District',
                'data-control' => 'select2',
                'x-model' => 'shopObj.districtId',
                'x-on:change' => 'getAndCheckUnit(),getUpazila()',
                'required' => 'required',
            ]) }}

            @error('district_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="{{ $className }} fv-row">

            {{ Form::label('upazila_id', 'Upazila', [
                'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
            ]) }}

            <select
                name="upazila_id"
                id="upazila_id"
                class="form-select form-select-solid {{ $errors->has('upazila_id') ? ' is-invalid' : null }}"
                x-model="shopObj.upazilaId" 
                x-on:change="getAndCheckUnit()"
                required="required"
                >
                <option value="0">Select Upazila</option>
                <template x-for="upazila in upazilas">
                    <option :value="upazila.id" x-text="upazila.name"></option>
                </template>
            </select>

            @error('upazila_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @if ($countUnitTypes() == 1)
            {{ Form::hidden('unit_type_id', $unitTypes->keys()->first()) }}
        @else
            <div class="col-md-4 fv-row">
                {{ Form::label('unit_type_id', 'Unit Type', [
                    'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                ]) }}

                {{ Form::select('unit_type_id', $unitTypes, null, [
                    'class' => 'form-select form-select-solid' . ($errors->has('unit_type_id') ? ' is-invalid' : null),
                    'placeholder' => 'Select unit type',
                    'required' => 'required',
                ]) }}

                @error('unit_type_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif
    </div>

    <div class="row g-9 mb-8">
        <div class="col-md-6 fv-row">
            {{ Form::label('name', config('conf.unit') . ' Name', [
                'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
            ]) }}

            {{ Form::text('name', null, [
                'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                'placeholder' => 'Enter ' . config('conf.unit') . ' Name',
                'required' => 'required',
                'x-model' => 'shopObj.unitName',
                'x-on:change' => 'getAndCheckUnit()',
            ]) }}

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6 fv-row">
            {{ Form::label('mobile', 'Mobile', [
                'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
            ]) }}

            {{ Form::text('mobile', null, [
                'class' => 'form-control form-control-solid' . ($errors->has('mobile') ? ' is-invalid' : null),
                'placeholder' => 'Enter Mobile',
                'required' => 'required',
                'x-model' => 'shopObj.mobile',
                'x-on:keyup' => 'getAndCheckUnit()',
            ]) }}

            @error('mobile')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('unitObj', () => ({
            oldUpazilaId:"{{ $selectedArr['upazilaId']}}",
            shopObj: {
                unitName:"{{ $selectedArr['unitName'] }}",
                mobile:"{{ $selectedArr['mobile'] }}",
                districtId:"{{ $selectedArr['districtId']}}",
                upazilaId:0
            },
            route: "{{ route('ajax.unit.getAndChecckUnit') }}",
            upazilaRoute:"{{ route('ajax.upazilas.list','districtIdd') }}",
            upazilas:[],
            getUpazila(){
                axios.get(
                        this.upazilaRoute.replace('districtIdd', this.shopObj.districtId)
                    )
                    .then((res) => {
                        this.upazilas = res.data
                    })
                    .then(() => {
                        this.shopObj.upazilaId = this.oldUpazilaId;
                    })
            },
            getAndCheckUnit() {
                if(this.shopObj.mobile.length && this.shopObj.mobile.length > 6 ){

                    axios.post(this.route, this.shopObj)
                        .then(function(response) {
                            console.log(response);
                        })
                        .catch(function(error) {
                            console.log(error);
                    });

                }
            },
            @if (old('district_id') || $unit)
                init() {
                    this.getUpazila();
                },
            @endif
        }));
    });
</script>
@endpush
