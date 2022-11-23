<x-app-layout>
    @slot('title')
        Edit Field Group
    @endslot

    <x-slot name="subheader">
        <x-subheader-comp>
            Edit Field Group for {{ $fieldGroup->form_name }}
            @slot('actions')
                {!! Html::decode(
                    link_to_route('forms.field-groups.index', 'Field Groups', $fieldGroup->form_id, [
                        'class' => 'btn btn-sm btn-light',
                    ]),
                ) !!}
            @endslot
        </x-subheader-comp>
    </x-slot>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-15">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ Form::model($fieldGroup, [
                    'route' => ['forms.field-groups.update', [$fieldGroup->form_id, $fieldGroup->id]],
                    'class' => 'form',
                    'method' => 'PUT',
                ]) }}

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        {{ Form::label('name', 'Field Group Name', ['class' => 'd-flex align-items-center fs-6 fw-bold mb-2 required']) }}

                        {{ Form::text('name', $fieldGroup->name, [
                            'class' => 'form-control form-control-solid' . ($errors->has('name') ? ' is-invalid' : null),
                            'placeholder' => 'Enter Field Group Name',
                            'required' => 'required',
                        ]) }}

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 fv-row">
                        {{ Form::label('status', 'Status', [
                            'class' => 'required fs-6 fw-bold mb-2',
                        ]) }}

                        {{ Form::select('status', App\Enum\Status::array(), null, [
                            'class' => 'form-select form-select-solid' . ($errors->has('status') ? ' is-invalid' : null),
                            'placeholder' => 'Select a Status',
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
