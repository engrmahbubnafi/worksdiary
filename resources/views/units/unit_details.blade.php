{{-- <table class="table-row-dashed fs-6 gy-5 table align-middle" id="kt_table_users">
    <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="text-center">Unit Type</th>
            <th class="text-center">Name</th>
            <th class="text-center">Code</th>
            <th class="text-center">Owner</th>
            <th class="text-center">Dealer</th>
            <th class="text-center">Mobile</th>
            <th class="text-center">District</th>
            <th class="text-center">Upazila</th>
            <th class="text-center">Address</th>
            <th class="text-center">Latitude</th>
            <th class="text-center">Longitude</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>

    <tbody class="fw-bold text-gray-600">
        @foreach ($unitDetails as $unitDetail)
            <tr>
                <td class="text-center">
                    {{ $unitDetail->unit_type_name }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->name }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->code }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->owner }}
                </td>

                <td class="text-center">
                    @if ($unitDetail->as_dealer == 0)
                        No
                    @else
                        Yes
                    @endif
                </td>

                <td class="text-center">
                    {{ $unitDetail->mobile }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->district_name }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->upazila_name }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->address }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->latitude }}
                </td>

                <td class="text-center">
                    {{ $unitDetail->longitude }}
                </td>

                <td class="text-center">
                    @if ($unitDetail->status == 'active')
                        Active
                    @else
                        Inactive
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
