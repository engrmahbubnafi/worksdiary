 <!-- Tag Unit Modal Start -->
 <div x-data="tag">
     <x-modals.master-modal :form-attr="['route' => 'companies.units.tag', 'autocomplete' => 'off']">
         @slot('title')
             Tag this unit to "{{ $currentCompany?->title }}"
         @endslot

         <x-auth-validation-errors :errors="$errors->tag"></x-auth-validation-errors>

         <input type="hidden" name="company_id" value="{{ $currentCompany?->id }}">

         <div class="pb-2">
             <input type="hidden" name="unit_id" x-model="$store.local.unitId">
             <x-unit-search-comp company-id="{{ $currentCompany?->id }}"></x-unit-search-comp>
         </div>

         <template x-if="!zoneLoading && getLength(zones)">
             {{-- Zone Dropdown --}}
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
         </template>

         {{-- If there is no Zone available to tag --}}
         <template x-if="!zoneLoading && !getLength(zones)">
             <p class="text-danger pb-2">No zone is found.</p>
         </template>


         <template x-if="!areaLoading && getLength(areas)">
             {{-- Area Dropdown --}}
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
         </template>

         {{-- If there is no Zone available to tag --}}
         <template x-if="!areaLoading && !getLength(areas)">
             <p class="text-danger pb-2">No area is found.</p>
         </template>

         <template x-if="!asDealerUnit && !areaLoading && $store.local.unitId && !$store.local.asDealer">
             <div class="pb-2">
                 <input type="hidden" name="dealer_id" x-model="$store.local.dealerId">
                 <x-unit-search-comp label="Dealer" :is-dealer="true"></x-unit-search-comp>
             </div>
         </template>

         {{-- Pass unit ID with hidden input --}}
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

                     @if ($errors->tag->any())
                         // For documentation: https://getbootstrap.com/docs/5.0/components/modal/
                         let myModal = new bootstrap.Modal(document.getElementById('bb-modal'));
                         alpineThis.unitId = @json(old('unit_id'));

                         alpineThis.$store.local.unitId = alpineThis.unitId;
                         alpineThis.asDealerUnit = parseInt(@json(old('is_dealer')));

                         alpineThis.getZones();

                         myModal.show();
                     @endif

                     $(document).on('click', '.js-tag-modal-link', function(e) {
                         e.preventDefault();

                         let myModal = new bootstrap.Modal(document.getElementById(
                             'bb-modal'));

                         alpineThis.getZones();
                         myModal.show();
                     });
                 },
                 zoneLoading: true,
                 areaLoading: true,
                 oldObj: {
                     'unit_id': @json(old('unit_id')),
                     'zone_id': @json(old('zone_id')),
                     'area_id': @json(old('area_id')),
                     'dealer_id': @json(old('dealer_id')),
                 },
                 companies: {},
                 zones: {},
                 areas: {},
                 unitId: 0,
                 companyId: '{{ $currentCompany?->id }}',
                 zoneId: 0,
                 areaId: 0,
                 asDealerUnit: 0,
                 isBtnActive: false,
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
                 }
             }));
         });
     </script>
 @endpush
