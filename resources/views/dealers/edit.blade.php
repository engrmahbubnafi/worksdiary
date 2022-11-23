<x-app-layout>
    @slot('title')
        Edit Dealer
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Dealer
            @slot('actions')
                {!! Html::decode(link_to_route('dealers.index', 'Dealers List', null, ['class' => 'btn btn-sm btn-light'])) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">
                {{ Form::model($dealer, ['route' => ['dealers.update', $dealer->id], 'class' => 'form', 'method' => 'PATCH']) }}
                <div class="d-flex flex-column fv-row mb-8">
                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                        <span class="required">Dealer Name</span>
                    </label>
                    {{ Form::text('name', null, [
                        'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                        'required' => 'required',
                        'placeholder' => 'Enter Dealer Name',
                    ]) }}
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Mobile</label>
                        {{ Form::text('mobile', null, [
                            'class' => 'form-control form-control-solid' . ($errors->has('mobile') ? ' is-invalid' : null),
                            'required' => 'required',
                            'placeholder' => 'Enter User Mobile',
                        ]) }}
                        @error('mobile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">District</label>
                        {{ Form::select('district_id', $district, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('district_id') ? ' is-invalid' : null),
                            'onchange' => 'getUpazilaData(this.value)',
                        ]) }}
                        @error('district_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Thana</label>
                        {{ Form::select('thana_id', $upazilas, null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('thana_id') ? ' is-invalid' : null),
                            'id' => 'thana_id',
                        ]) }}
                        @error('thana_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-bold mb-2">Address</label>
                        {{ Form::textarea('address', null, [
                            'class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : null),
                            'id' => 'address',
                            'rows' => 2,
                        ]) }}
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}
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

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm ms-2 align-middle"></span>
                        </span>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            function getUpazilaData(data) {
                let selected_id = '';
                let selected = "";
                $('#thana_id').html('<option value="">Select One</option>');
                $.ajax({
                    url: "/{{ 'get-upazila' }}/" + data,
                    type: "GET",
                    dataType: 'json',
                    success: function(result) {
                        $.each(result, function(key, value) {
                            if (selected_id == value.id) {
                                selected = "selected";
                            } else {
                                selected = "";
                            }
                            $("#thana_id").append('<option value="' + value.id + '" ' + selected + '>' +
                                value.name + '</option>');
                        });
                    }
                });

            }
        </script>
    @endpush
</x-app-layout>
