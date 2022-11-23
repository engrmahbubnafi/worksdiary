<x-app-layout>
    @slot('title')
        Create New Emmergency Task
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New Emmergency Task for "{{ $currentCompany?->title }}"
            @slot('actions')
                {!! Html::decode(
                    link_to_route('emergency.visits.index', '<i class="fa fa-list"></i> Emmergency Task List', $companyId, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <!-- Company Tabs -->
            <x-tab-comp :lists="$lists"></x-tab-comp>

            <div class="card-body p-lg-15" x-data="createVisit" x-init="select2Alpine">

                {{ Form::model(request()->old(), [
                    'route' => ['companies.emergencyvisits.store', $companyId],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Task Objective', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::select('name[]', $visitObjectives, null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            //'required' => 'required',
                            'multiple' => 'multiple',
                            'id' => 'visitName',
                        ]) }}

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('date_for', 'Date For', [
                            'class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required',
                        ]) }}

                        {{ Form::date('date_for', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('date_for') ? ' is-invalid' : null),
                            //'required' => 'required',
                            'placeholder' => 'Enter Date',
                        ]) }}

                        @error('date_for')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('visit_note', 'Task Note', [
                            'class' => 'fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::text('visit_note', null, [
                            'class' => 'form-control form-control-solid',
                            'placeholder' => 'Write Task note',
                        ]) }}
                    </div>

                    <div class="col-md-6 fv-row">
                        <label for="zone_id"
                            class="d-flex align-items-center justify-content-between fs-6 fw-bold mb-2">
                            <span class="required">Zone</span>
                        </label>

                        {{ Form::select('zone_id', $zones, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('zone_id') ? ' is-invalid' : null),
                            'placeholder' => 'Select Zone',
                            'data-control' => 'select2',
                            'x-model' => 'zoneId',
                            'x-on:change' => 'getUnits()',
                            'id' => 'zone_id',
                            //'data-hide-search' => 'true',
                            //'required' => 'required',
                        ]) }}

                        @error('zone_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <label for="company_unit_id"
                            class="d-flex align-items-center justify-content-between fs-6 fw-bold mb-2">
                            <span class="required">Unit</span>

                            <button type="button"
                                class="btn btn-icon btn-sm btn-success me-2 js-tag-modal-link h-25px">
                                <i class="fa fa-2x fa-plus"></i>
                            </button>

                        </label>
                        <select placeholder="Select Unit" data-control="select2"
                            class="form-select form-select-solid{{ $errors->has('company_unit_id') ? ' is-invalid' : null }}"
                            name="company_unit_id" x-model="companyUnitId" id="unitId"
                            x-on:change='getUnitTypesNVisitors()'>
                            <option value="">Select Unit</option>
                            <template x-for="unit in units" :key="unit.company_unit_id">
                                <option x-text="getUnitFullName(unit)" :value="unit.company_unit_id"></option>
                            </template>
                        </select>


                        @error('company_unit_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 fv-row">
                        {{ Form::label('assign_to', 'Assign To', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}
                        <select placeholder="Select Visitor" data-control="select2"
                            class="form-select form-select-solid{{ $errors->has('assign_to') ? ' is-invalid' : null }}"
                            name="assign_to">
                            <option value="">Select Visitor</option>
                            <template x-for="unitVisitor in unitVisitors" :key="unitVisitor.id">
                                <option x-text="getVisitorFullName(unitVisitor)" :value="unitVisitor.id"></option>
                            </template>
                        </select>

                        @error('assign_to')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">

                    <template x-if="!unitTypeLoading && companyUnitId && getLength(unitTypes)>1">
                        <div class="col-md-6 fv-row">
                            {{ Form::label('unit_type_id', 'Unit Type', [
                                'class' => 'required fs-6 fw-bold mb-2',
                            ]) }}
                            <template x-if="!unitTypeLoading && companyUnitId && getLength(unitTypes) > 1">
                                <select
                                    class="form-select form-select-solid {{ $errors->has('unit_type_id') ? ' is-invalid' : null }}"
                                    name="unit_type_id" x-model="unitTypeId">
                                    <template x-for="(unit_type_name,unit_type_id) in unitTypes" :key="unit_type_id">
                                        <option x-text="unit_type_name" :value="unit_type_id"></option>
                                    </template>
                                </select>
                            </template>

                            @error('unit_type_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <template x-if="!unitTypeLoading && companyUnitId && !getLength(unitTypes)">
                                <p class="text-danger pb-2">No unit type is found.</p>
                            </template>
                        </div>
                    </template>
                    <template x-if="!unitTypeLoading && companyUnitId && getLength(unitTypes)==1">
                        <input type="hidden" name="unit_type_id" x-model="unitTypeId">
                    </template>
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

    @include('units.tag-unit-with-company')

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('createVisit', () => ({
                    init() {
                        $("#visitName").select2({
                            tags: true
                        });
                        this.companyId = @json($companyId);
                        @if (old('zone_id'))
                            this.getUnits();
                        @endif

                    },
                    // Initializing the variables.
                    zoneId: @json(old('zone_id')),
                    companyUnitId: 0,
                    companyId: 0,
                    unitTypeId: 0,
                    unitTypes: {},
                    units: [],
                    unitTypeLoading: true,
                    unitVisitors: [],
                    unitVisitorLoading: true,
                    unitTypeRoute: "{{ route('ajax.visit.getUnitTypesByUnit') }}",
                    unitVisitorRoute: "{{ route('ajax.visit.getVisitors') }}",
                    unitRoute: "{{ route('ajax.visit.getUnitsByZone') }}",

                    // Get the length of an object.
                    getLength(object) {
                        return Object.keys(object).length;
                    },
                    //Get units according to selected zone
                    getUnits() {
                        this.units = [];
                        return axios.post(this.unitRoute, {
                                company_id: this.companyId,
                                zone_id: this.zoneId
                            })
                            .then(
                                (res) => {
                                    this.units = res.data;
                                    //this.unitTypeLoading = false;
                                }
                            )
                            .then(
                                () => {
                                    if (this.units.length) {
                                        this.companyUnitId = this.units[0]['id'];
                                    }
                                }
                            );
                    },

                    // Get unit types according to selected unit.
                    getUnitTypes() {
                        this.unitTypes = {};
                        this.unitTypeId = 0;
                        this.unitTypeLoading = true;

                        return axios.post(this.unitTypeRoute, {
                                unitId: this.companyUnitId
                            })
                            .then(
                                (res) => {
                                    this.unitTypes = res.data;
                                    this.unitTypeLoading = false;
                                }
                            )
                            .then(
                                () => {
                                    if (this.getLength(this.unitTypes)) {
                                        this.unitTypeId = Object.keys(this.unitTypes)[0];
                                    }
                                }
                            );
                    },

                    getVisitors() {
                        this.unitVisitors = [];
                        this.unitVisitorLoading = true;
                        return axios.post(this.unitVisitorRoute, {
                                company_unit_id: this.companyUnitId
                            })
                            .then(
                                (res) => {
                                    this.unitVisitors = res.data;
                                    //console.log(this.unitVisitors[0]['name']);
                                    this.unitVisitorLoading = false;
                                }
                            );
                    },
                    getUnitTypesNVisitors() {
                        this.unitTypes = {};
                        if (this.companyUnitId) {

                            this.getUnitTypes();
                            this.getVisitors();
                        }
                    },

                    getUnitFullName(unit) {
                        return unit.name + ' | ' + unit.code + ' | ' + unit.mobile;
                    },

                    getVisitorFullName(unitVisitor) {
                        return unitVisitor.name + ' | ' + unitVisitor.email + ' | ' + unitVisitor.mobile;
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>
