<x-app-layout>
    @slot('title')
        Edit Tag
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Tag
            @slot('actions')
                {!! Html::decode(
                    link_to_route('units.create', '<i class="fa fa-plus"></i> New Unit', null, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl" x-data="editTag">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model($companyUnit, ['route' => ['companies.units.tag.update', [$companyUnit->company_id, $companyUnit->unit_id]]]) }}

                {{-- Pass company_id & unit_id with hidden input. --}}
                <input type="hidden" name="company_id" value="{{ $companyUnit->company_id }}">
                <input type="hidden" name="unit_id" value="{{ $companyUnit->unit_id }}">

                {{-- Zone Dropdown --}}
                <div class="pb-2">
                    <label class="fs-6 fw-bold mb-2 pr-3 required">Zone</label>
                    <select name="zone_id"
                        class="form-select form-select-solid {{ $errors->has('zone_id') ? ' is-invalid' : null }} mb-3"
                        x-model="zoneId" x-on:change="getAreas()" required="required">
                        <template x-for="(zone, id) in zones" :key="id">
                            <option :value="id" x-text="zone"></option>
                        </template>
                    </select>
                </div>

                {{-- Area Dropdown --}}
                <div class="pb-2">
                    <label class="fs-6 fw-bold mb-2 pr-3">Area</label>
                    <select name="area_id"
                        class="form-select form-select-solid {{ $errors->has('area_id') ? ' is-invalid' : null }} mb-3"
                        x-model="areaId" required="required">
                        <template x-for="(area, id) in areas" :key="id">
                            <option :value="id" x-text="area"></option>
                        </template>
                    </select>
                </div>


                {{ Form::submit('Confirm', ['class' => 'btn btn-primary']) }}

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('editTag', () => ({
                    init() {
                        // Get zones by company
                        this.getZones();
                    },
                    companyId: @json($companyUnit->company_id),
                    zoneId: @json($companyUnit->zone_id),
                    areaId: @json($companyUnit->area_id),
                    dealerId: @json($companyUnit->dealer_id),
                    zones: {},
                    areas: {},
                    zoneLoading: true,
                    areaLoading: true,
                    zoneRoute: "{{ route('ajax.zones.getZonesByCompany', 'companyId') }}",
                    areaRoute: "{{ route('ajax.areas.getAreasByZone', 'zoneId') }}",
                    oldObj: {
                        'zone_id': @json(old('zone_id')),
                        'area_id': @json(old('area_id')),
                    },
                    getLength(object) {
                        return Object.keys(object).length;
                    },
                    getAreas() {
                        this.areaId = 0;
                        this.areas = {};

                        return axios.get(
                                this.areaRoute.replace('zoneId', this.zoneId)
                            )
                            .then((res) => {
                                this.areas = res.data;
                            });
                    },
                    getZones() {
                        return axios.get(
                                this.zoneRoute.replace('companyId', this.companyId)
                            )
                            .then((res) => {
                                this.zones = res.data;
                            })
                            .then(() => {
                                if (this.getLength(this.zones)) {
                                    this.getAreas();
                                }
                            });
                    }
                }))
            })
        </script>
    @endpush

</x-app-layout>
