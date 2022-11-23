{!! Form::select('reference_value', $referenceValues, null, [
    'class' => 'form-control form-control-solid' . ($errors->has('reference_value') ? ' is-invalid' : null),
    'placeholder' => 'Select Reference Value',
    'x-model' => 'reference_value',
    'data-control' => 'select2',
]) !!}
