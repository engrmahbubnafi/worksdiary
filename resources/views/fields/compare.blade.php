{!! Form::select('compare_value', $compareValues, null, [
    'class' => 'form-control form-control-solid' . ($errors->has('compare_value') ? ' is-invalid' : null),
    'placeholder' => 'Select Compare Value',
    'x-model' => 'compare_value',
    'data-control' => 'select2',
]) !!}
