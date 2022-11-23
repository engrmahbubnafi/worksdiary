{{-- Company Dropdown Start --}}
@if ($companies->count() > 1)
    {{ Form::select('company_id', $companies, null, [
        'class' => 'form-select form-select-solid mb-3' . ($errors->has('company_id') ? ' is-invalid' : null),
        'placeholder' => 'Select Company',
        'id' => 'company_id',
        'x-model' => 'tagUnitObject.companyId',
        'x-on:change' => 'getZones(),getAreas()',
    ]) }}
@else
    {{ Form::hidden('company_id', $companies->keys()->first()) }}
@endif
{{-- Company Dropdown End --}}

{{-- Zone Dropdown Start --}}
<select name="zone_id" class="form-select form-select-solid {{ $errors->has('zone_id') ? ' is-invalid' : null }} mb-3"
    x-model="tagUnitObject.zoneId" x-on:change="getZones()", required="required">
    <option value="0">Select Zone</option>
    <template x-for="zone in zones">
        <option :value="zone.id" x-text="zone.name"></option>
    </template>
</select>

@error('zone_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
{{-- Zone Dropdown End --}}

{{-- Area Dropdown Start --}}
<select name="area_id"
    class="form-select form-select-solid {{ $errors->has('area_id') ? ' is-invalid' : null }} js-area-id"
    x-model="tagUnitObject.areaId" x-on:change="getAreas()", required="required">
    <option value="0">Select Area</option>
    <template x-for="area in areas">
        <option :value="area.id" x-text="area.name"></option>
    </template>
</select>

@error('area_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
{{-- Area Dropdown End --}}
