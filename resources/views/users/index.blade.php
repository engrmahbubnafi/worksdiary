<x-app-layout>
    @slot('title')
        Users List
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Users List
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'users.create',
                        '<i class="fa fa-plus"></i> New User',
                        auth()->user()->company_id == $companyId ? null : $companyId,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>

    </x-slot>

    <x-common-for-index :html="$html">
        <x-tab-comp :lists="$lists">

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

        </x-tab-comp>
    </x-common-for-index>

    <!-- Transfer User Modal -->
    <x-modals.master-modal :form-attr="['route' => 'user.transfer']">
        @slot('title')
            Transfer this user to another company
        @endslot

        {{ Form::select('company_id', [], null, [
            'class' => 'form-select form-select-solid' . ($errors->has('company_id') ? ' is-invalid' : null),
            'placeholder' => 'Select Company',
            'id' => 'transfer-to',
        ]) }}

        @error('company_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        {{ Form::hidden('user_id', null, ['id' => 'user_id']) }}

        @slot('actions')
            {{ Form::submit('Confirm', ['class' => 'btn btn-primary']) }}
        @endslot
    </x-modals.master-modal>


    @push('scripts')
        <script>
            let companiesObj = @json($companies);

            function generateOptionHtml(companiesObj, companyId) {
                let companies = _.clone(companiesObj);
                delete companies[companyId];

                let html = "";
                _.forEach(companies, function(value, key) {
                    html += `<option value="${key}">${value}</option>`;
                });
                return html;
            }

            // Transfer user modal
            @if ($errors->any())
                /*
                    https://getbootstrap.com/docs/5.0/components/modal/
                */
                var myModal = new bootstrap.Modal(document.getElementById('bb-modal'));
                myModal.show();
            @else
                $('#bb-modal').on('show.bs.modal', function(event) {
                    let button = $(event.relatedTarget); // Button that triggered the modal
                    let userId = button.data('id') // Extract info from data-* attributes

                    let companyId = button.data('company');

                    let html = generateOptionHtml(companiesObj, companyId);


                    let modal = $(this);
                    modal.find('#user_id').val(userId);

                    modal.find('#transfer-to').html(html);
                })
            @endif
        </script>
    @endpush
</x-app-layout>
