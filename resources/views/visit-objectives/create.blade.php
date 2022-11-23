<x-app-layout>
    @slot('title')
        Create New Visit Objective
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            New Visit Objective for "{{ $currentCompany?->title }}"
            @slot('actions')
                {!! Html::decode(
                    link_to_route(
                        'visit-objectives.index',
                        '<i class="fa fa-list"></i> Visit Objective List',
                        $companyId == 1 ? null : $companyId,
                        [
                            'class' => 'btn btn-sm btn-light',
                        ],
                    ),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <x-tab-comp :lists="$lists"></x-tab-comp>

            <div class="card-body p-lg-15">

                {{ Form::model(request()->old(), [
                    'route' => ['companies.visit-objectives.store', $companyId],
                    'class' => 'form',
                    'method' => 'POST',
                ]) }}

                {{-- <input type="hidden" value="{{ $companyId }}"> --}}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('title', 'Title', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::text('title', null, [
                            'class' => 'form-control form-control-solid',
                            'placeholder' => 'Insert title',
                        ]) }}

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::select('status', App\Enum\Status::array(), App\Enum\Status::Active->value, [
                            'class' => 'form-select form-select-solid' . ($errors->has('status') ? ' is-invalid' : null),
                            'placeholder' => 'Select Status',
                            'data-control' => 'select2',
                            // 'data-hide-search' => 'true',
                            'required' => 'required',
                        ]) }}

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
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
</x-app-layout>
