@aware(['html'])

<div x-data="{{ $dataName }}">
    <label class="fs-6 fw-bold mb-2 pr-3">{{ $label }}:</label>
    <div class="header-search d-flex align-items-stretch">
        <section class="w-100 position-relative mb-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <input type="hidden" />

            <!-- Search Icon -->
            <span
                class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                        transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                    <path
                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!-- Search Icon -->

            <!-- Search Input -->
            <input type="text" class="form-control form-control-lg form-control-solid px-15" name="search"
                placeholder="Search by code, name or mobile..." data-search-element="input" x-model="searchInput"
                @input.debounce.500ms="getUnits" />
            <!-- Search Input -->

            <!-- Spinner -->
            <template x-if="spinner">
                <span class="position-absolute top-50 end-0 translate-middle-y lh-0 me-5" data-search-element="spinner">
                    <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                </span>
            </template>
            <!-- Spinner -->

            <!-- Show cross icon for clearing search input when there is result(s) -->
            <template x-if="searchResult.length">
                <span
                    class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5"
                    data-search-element="clear" x-on:click="clear()">
                    <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </span>
            </template>
        </section>

        <!-- Search Results -->
        <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown w-450px" data-kt-menu="true"
            id="{{ $menuId }}">
            <!-- Result Outputs -->
            <template x-if="searchResult.length">
                <div data-search-element="results" class="p-7">
                    <div class="mh-300px scroll-y me-n5 pe-5">
                        <template x-for="(obj, key) in searchResult" :key="key">
                            <div
                                class="d-flex align-items-center justify-content-center p-3 rounded-3 border-hover border border-dashed border-gray-300 cursor-pointer mb-1">
                                <div class="fw-bold text-center">

                                    <!-- Searched Units -->
                                    <div class="fs-6 text-gray-800 me-2" data-id="obj.id"
                                        style="border: none; background: none;">
                                        <span class="badge badge-light" style="border: none;" x-text="obj.code"></span>
                                        <template x-if="obj.as_dealer">
                                            <span class="badge badge-light" style="border: none;"
                                                x-text="'Dealer Unit'"></span>
                                        </template>
                                        <br>
                                        <strong x-text="obj.name"></strong><br>
                                        <span class="badge badge-light" x-text="obj.mobile"></span>
                                    </div>
                                    <!-- Searched Units -->

                                    <!-- View Button -->
                                    <button class="badge badge-dark" type="button" style="border: none;"
                                        x-on:click="getDetails(obj.id, obj.code)">
                                        View Details
                                    </button>
                                    <!-- View Button -->

                                    <!-- Select Button -->
                                    <button class="badge badge-info" type="button" style="border: none;"
                                        x-on:click="getSelectedUnit(obj)">
                                        Select to Add
                                    </button>
                                    <!-- Select Button -->
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            <!-- Result Outputs -->

            <!-- Show message if no result found -->
            <template x-if="searchInput.length && !searchResult.length">
                <div data-search-element="empty" class="text-center p-7">
                    <div class="fw-bold py-0 mb-10">
                        <div class="text-gray-600 fs-3 mb-2">No units found</div>
                        <div class="text-gray-400 fs-6">Try to search by code, name or mobile...</div>
                    </div>
                </div>
            </template>
            <!-- Show message if no result found -->
        </div>
        <!-- Search Results -->
    </div>

    <!-- Show selected unit. -->
    <template x-if="getLength(selectedUnitObj)">
        <div>
            <strong x-text="selectedUnitObj.code"></strong>
            (<span x-text="selectedUnitObj.name"></span>,<span x-text="selectedUnitObj.mobile"></span>)
        </div>
    </template>
    <!-- Show selected unit. -->

    <!-- View Details Modal -->
    <x-modals.master-modal :modal-id="$dataName" modal-class="modal-lg">
        @slot('title')
            Details of <span x-text="unitCode"></span>
        @endslot

        <template x-if="getLength(unitDetails)">
            <div class="card-body py-4 table-responsive">
                <table class="table-row-dashed fs-6 gy-5 table align-middle" id="kt_table_users">
                    <tbody>
                        <tr>
                            <th>Unit Type</th>
                            <td x-text="unitDetails.unit_type"></td>
                        </tr>

                        <tr>
                            <th>Unit</th>
                            <td x-text="unitDetails.unit"></td>
                        </tr>

                        <tr>
                            <th>Code</th>
                            <td x-text="unitDetails.code"></td>
                        </tr>

                        <tr>
                            <th>Owner</th>
                            <td x-text="unitDetails.owner"></td>
                        </tr>

                        <tr>
                            <th>Dealer</th>
                            <td x-text="unitDetails.dealer"></td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td x-text="unitDetails.mobile"></td>
                        </tr>

                        <tr>
                            <th>Address</th>
                            <td x-text="unitDetails.address"></td>
                        </tr>

                        <tr>
                            <th>Location</th>
                            <td x-text="unitDetails.location"></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td x-text="unitDetails.status"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>

        <template x-if="!getLength(unitDetails)">
            <div>No details of this unit!</div>
        </template>

    </x-modals.master-modal>
    <!-- View Details Modal -->
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('{{ $dataName }}', () => ({
                route: "{{ route('ajax.unitSearch.unitList') }}",
                detailsRoute: "{{ route('ajax.unit.show', 'unitId') }}",
                spinner: false,
                searchInput: "",
                searchResult: [],
                selectedUnit: 0,
                selectedUnitObj: {},
                menuInstance: null,
                unitCode: 0,
                unitDetails: {},
                clear() {
                    this.searchInput = "";
                    this.searchResult = [];
                },
                getLength(object) {
                    return Object.keys(object).length;
                },
                getUnits() {
                    this.spinner = true;

                    return axios.post(this.route, {
                            search_text: this.searchInput

                            @if ($isDealer)
                                , by_unit_id: this.$store.local.unitId
                            @endif

                            @if(!empty($companyId))
                                , company_id: @json($companyId)
                            @endif
                        })
                        .then((res) => {
                            this.searchResult = res.data;
                            this.spinner = false;
                        })
                        .then(() => {
                            this.menuInstance.show();
                        });
                },
                getDetails(unitId, unitCode) {
                    console.log("Unit ID: " + unitId);

                    this.unitCode = unitCode;

                    this.menuInstance.hide();

                    return axios.get(
                            this.detailsRoute.replace('unitId', unitId)
                        )
                        .then(
                            (res) => {
                                this.unitDetails = res.data.data;
                            }
                        )
                        .then(
                            () => {
                                let myModal = new bootstrap.Modal(document.getElementById(
                                    '{{ $dataName }}'));
                                myModal.show();
                            }
                        );
                },
                getSelectedUnit(obj) {
                    this.selectedUnitObj = obj;

                    @if ($isDealer)
                        this.$store.local.dealerId = this.selectedUnitObj.id;
                    @else
                        this.$store.local.unitId = this.selectedUnitObj.id;
                        this.$store.local.dealerId = 0;
                        this.$store.local.asDealer = this.selectedUnitObj.as_dealer;
                    @endif

                    this.searchInput = "";
                    this.searchResult = [];
                },
                init() {
                    KTMenu.createInstances(); //for all menu
                    var menuElement = document.querySelector("#{{ $menuId }}");
                    this.menuInstance = KTMenu.getInstance(menuElement);
                }
            }))
        })
    </script>
@endpush
