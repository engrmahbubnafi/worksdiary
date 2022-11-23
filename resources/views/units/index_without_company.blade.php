<x-app-layout>
    @slot('title')
        Units
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Units
            @slot('actions')
                {!! Html::decode(
                    link_to_route('units.create', '<i class="fa fa-plus"></i> New Unit', null, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <x-common-for-index :html="$html">
        <x-tab-comp :lists="$lists">
            <div class="d-flex align-items-center position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                            transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <input type="text" data-kt-table-filter="search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search">
            </div>
        </x-tab-comp>
    </x-common-for-index>

    <!-- Tag Unit Modal Start -->
    <div x-data="tag">
        <x-modals.master-modal :form-attr="['route' => 'companies.units.tag', 'autocomplete' => 'off']">
            @slot('title')
                Tag this unit to company
            @endslot

            <x-auth-validation-errors :errors="$errors"></x-auth-validation-errors>

            {{-- If there are more than 1 company --}}
            <template x-if="getLength(companies) &&  getLength(companies) > 1">
                {{-- Company Dropdown Start --}}
                <div class="pb-2">
                    <label class="fs-6 fw-bold mb-2 pr-3 required">Company:</label>
                    <select name="company_id" class="form-select form-select-solid mb-3" x-model="companyId"
                        x-on:change="getZones" required="required">
                        <template x-for="(company, id) in companies" :key="id">
                            <option :value="id" x-text="company"></option>
                        </template>
                    </select>
                </div>
                {{-- Company Dropdown End --}}
            </template>

            {{-- If there is only 1 company --}}
            <template x-if="getLength(companies) && getLength(companies) == 1">
                <div class="pb-2">
                    <label class="fs-6 fw-bold mb-2 pr-3">Company:</label> <strong x-cloak
                        x-text="companies[companyId]"></strong>
                    <input type="hidden" name="company_id" x-model="companyId">
                </div>
            </template>

            {{-- If there is no company available to tag --}}
            <template x-if="!getLength(companies)">
                <h5 class="text-danger">Unit alrady tagged with available company/companies</h5>
            </template>

            <template x-if="!zoneLoading && getLength(zones)">
                {{-- Zone Dropdown Start --}}
                <div class="pb-2">
                    <label class="fs-6 fw-bold mb-2 pr-3 required">Zone:</label>
                    <select name="zone_id"
                        class="form-select form-select-solid {{ $errors->has('zone_id') ? ' is-invalid' : null }} mb-3"
                        x-model="zoneId" x-on:change="getAreas" required="required">
                        <template x-for="(zone, id) in zones" :key="id">
                            <option :value="id" x-text="zone"></option>
                        </template>
                    </select>
                </div>
                {{-- Zone Dropdown End --}}
            </template>

            {{-- If there is no Zone available to tag --}}
            <template x-if="!zoneLoading && !getLength(zones)">
                <p class="text-danger pb-2">No zone is found.</p>
            </template>


            <template x-if="!areaLoading && getLength(areas)">
                {{-- Area Dropdown Start --}}
                <div class="pb-2">
                    <label class="fs-6 fw-bold mb-2 pr-3">Area:</label>
                    <select name="area_id"
                        class="form-select form-select-solid {{ $errors->has('area_id') ? ' is-invalid' : null }} mb-3"
                        x-model="areaId" required="required">
                        <template x-for="(area, id) in areas" :key="id">
                            <option :value="id" x-text="area"></option>
                        </template>
                    </select>
                </div>
                {{-- Area Dropdown End --}}
            </template>

            {{-- If there is no Zone available to tag --}}
            <template x-if="!areaLoading && !getLength(areas)">
                <p class="text-danger pb-2">No area is found.</p>
            </template>

            <template x-if="!asDealerUnit && !areaLoading">
                <div class="pb-2">
                    <input type="hidden" name="dealer_id" x-model="$store.local.dealerId">
                    <x-unit-search-comp label="Dealer" :is-dealer="true"></x-unit-search-comp>
                </div>
            </template>

            {{-- Pass unit_id and is_dealer with hidden input --}}
            <input type="hidden" name="unit_id" x-model="unitId">
            <input type="hidden" name="is_dealer" x-model="asDealerUnit">

            @slot('actions')
                {{ Form::submit('Confirm', ['class' => 'btn btn-primary', 'x-bind:disabled' => '!isBtnActive']) }}
            @endslot
        </x-modals.master-modal>
        <!-- Tag Unit Modal End -->
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {

                Alpine.data('tag', () => ({
                    init() {
                        let alpineThis = this;

                        @if ($errors->any())
                            // For documentation: https://getbootstrap.com/docs/5.0/components/modal/
                            let myModal = new bootstrap.Modal(document.getElementById('bb-modal'));
                            alpineThis.unitId = @json(old('unit_id'));

                            alpineThis.$store.local.unitId = alpineThis.unitId;
                            alpineThis.asDealerUnit = parseInt(@json(old('is_dealer')));
                            alpineThis.getCompanies();

                            myModal.show();
                        @endif

                        $(document).on('click', '.js-tag-modal-link', function(e) {
                            e.preventDefault();

                            let myModal = new bootstrap.Modal(document.getElementById(
                                'bb-modal'));
                            alpineThis.unitId = $(this).attr(
                                "data-id"
                            );

                            alpineThis.$store.local.unitId = alpineThis.unitId;

                            let asDealer = $(this).attr(
                                "data-dealer"
                            );

                            alpineThis.asDealerUnit = parseInt(asDealer);

                            alpineThis.getCompanies();
                            myModal.show();
                        });
                    },
                    zoneLoading: true,
                    areaLoading: true,
                    oldObj: {
                        'company_id': @json(old('company_id')),
                        'zone_id': @json(old('zone_id')),
                        'area_id': @json(old('area_id')),
                        'dealer_id': @json(old('dealer_id')),
                    },
                    companies: {},
                    zones: {},
                    areas: {},
                    unitId: 0,
                    companyId: 0,
                    zoneId: 0,
                    areaId: 0,
                    asDealerUnit: 0,
                    isBtnActive: false,
                    companyRoute: "{{ route('ajax.companies.getUnTaggeedCompanies', 'unitId') }}",
                    zoneRoute: "{{ route('ajax.zones.getZonesByCompany', 'companyId') }}",
                    areaRoute: "{{ route('ajax.areas.getAreasByZone', 'zoneId') }}",
                    getLength(object) {
                        return Object.keys(object).length;
                    },
                    getAreas() {
                        this.areaLoading = true;

                        this.areas = {};
                        this.areaId = 0;

                        return axios.get(
                                this.areaRoute.replace('zoneId', this.zoneId)
                            )
                            .then((res) => {
                                this.areas = res.data;
                                this.areaLoading = false;
                            })
                            .then(() => {
                                if (this.getLength(this.areas)) {
                                    if (this.oldObj.area_id) {
                                        this.zoneId = this.oldObj.area_id;
                                        this.oldObj.area_id = null;
                                    } else {
                                        this.areaId = Object.keys(this.areas)[0];
                                    }
                                }
                            });
                    },
                    getZones() {
                        this.zoneLoading = true;

                        this.zones = {};
                        this.zoneId = 0;

                        this.areas = {};
                        this.areaId = 0;

                        return axios.get(
                                this.zoneRoute.replace('companyId', this.companyId)
                            )
                            .then((res) => {
                                this.zones = res.data;
                                this.zoneLoading = false;
                            })
                            .then(() => {
                                if (this.getLength(this.zones)) {
                                    if (this.oldObj.zone_id) {
                                        this.zoneId = this.oldObj.zone_id;
                                        this.oldObj.zone_id = null;
                                    } else {
                                        this.zoneId = Object.keys(this.zones)[0];
                                    }
                                    this.isBtnActive = true;
                                }
                            })
                            .then(() => {
                                if (this.zoneId) {
                                    this.getAreas();
                                }
                            });
                    },
                    getCompanies() {
                        this.companies = {};
                        this.companyId = 0;

                        this.zones = {};
                        this.zoneId = 0;

                        this.areas = {};
                        this.areaId = 0;

                        return axios.get(
                                this.companyRoute.replace('unitId', this.unitId)
                            )
                            .then((res) => {
                                this.companies = res.data;
                            })
                            .then(() => {
                                if (this.getLength(this.companies)) {
                                    if (this.oldObj.company_id) {
                                        this.companyId = this.oldObj.company_id;
                                        this.oldObj.company_id = null;
                                    } else {
                                        this.companyId = Object.keys(this.companies)[0];
                                    }
                                }
                            })
                            .then(() => {
                                if (this.companyId) {
                                    this.getZones();
                                }
                            });
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>
