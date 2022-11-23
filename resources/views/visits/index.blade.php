<x-app-layout>
    @slot('title')
        Visits
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Visits
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'visits.create',
                        '<i class="fa fa-plus"></i> New Visit',
                        auth()->user()->company_id == $companyId ? null : $companyId,
                        ['class' => 'btn btn-sm btn-light'],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <x-common-for-index :html="$html">
        <x-tab-comp :lists="$lists">

            <!--begin::Daterangepicker-->
           <input class="form-control form-control-solid w-100 mw-250px" placeholder="Pick date range" id="kt_daterangepicker" />
           <!--end::Daterangepicker-->
           <!--begin::Filter-->
           <div class="w-250px">
               <!--begin::Select2-->
               {{ Form::select('status', App\Enum\VisitStatus::array(), null, [
                    'class' => 'form-select form-select-solid',
                    'data-kt-select2'=>'true',
                    'data-placeholder'=>'Select option',
                    'id'=>'visitStatus',
                    'data-allow-clear'=>'true',
                ]) }}
               <!--end::Select2-->
           </div>
          
             <!--begin::search -->
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                            transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <input type="text" data-kt-table-filter="search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search">
            </div> 
            <!--end::search -->           

        </x-tab-comp>
    </x-common-for-index>

    @push('scripts')
        <script>
            var start = moment().subtract(29, "days");
            var end = moment();

            function cb(start, end) {
                $("#kt_daterangepicker").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
            }

            $("#kt_daterangepicker").daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    "Today": [moment(), moment()],
                    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                }
            }, cb);

            cb(start, end);

            $('#kt_daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                console.log(ev);
                window.LaravelDataTables["dataTableBuilder"].column(3).search(picker.startDate.format('YYYY-MM-DD')+'|'+picker.endDate.format('YYYY-MM-DD')).draw();
            });


            $(document).on('change','#visitStatus',function(e){
                window.LaravelDataTables["dataTableBuilder"].column(4).search(e.currentTarget.value).draw();
            });    
          
        </script>
    @endpush
</x-app-layout>