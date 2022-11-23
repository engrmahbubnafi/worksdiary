<?php
namespace App\Http\Controllers\Traits;

use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\FieldType;
use App\Models\Form;
use App\Models\Source;
use App\Transformers\FieldTransformer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

trait AllPrivateMethodsForFieldController
{
    /**
     * Get field table joining other needed tables.
     *
     * @param int $formId
     * @return object
     */
    private function getFieldData(int $formId): object
    {
        // Get fields with other necessary tables
        $fields = Field::select(
            'fields.*',
            'forms.name as form_name',
            'field_groups.name as field_group_name',
            'field_types.input_type as field_type_name',
            'sources.name as source_name'
        )
            ->join('forms', 'forms.id', '=', 'fields.form_id')
            ->leftJoin('sources', 'sources.id', '=', 'fields.compare_value')
            ->leftJoin('field_types', 'field_types.id', '=', 'fields.field_type_id')
            ->leftJoin('field_groups', 'field_groups.id', '=', 'fields.field_group_id')
            ->where('fields.form_id', $formId)
            ->get();

        return DataTables::of($fields)
            ->setTransformer(new FieldTransformer)
            ->toJson();
    }

    /**
     * Fetch common data required for create and edit forms.
     *
     * @param int $formId
     * @return array
     */
    private function data(int $formId): array
    {
        // Get only those companies which are linked to the user
        $companies = app('authCompanies');

        return [
            'forms' => Form::active()
                ->whereIn('company_id', $companies->keys())
                ->pluck('name', 'id'),

            'fieldGroup' => FieldGroup::where('form_id', $formId)
                ->active()
                ->pluck('name', 'id'),

            'fieldType' => FieldType::active()
                ->pluck('input_type', 'id'),
        ];
    }

    /**
     * Ajax Show reference values based on selected form.
     *
     * @param int $formId
     * @param int $fieldId
     * @return \Illuminate\Http\Response
     */
    private function getReferenceValues(int $formId, int $fieldId = null)
    {
        $query = Field::leftJoin('field_groups', 'field_groups.id', 'fields.field_group_id')
            ->where('fields.form_id', $formId)
            ->where('fields.is_required', true);

        if ($fieldId) {
            $query->where('fields.id', '<>', $fieldId);
        }

        $query->select(
            'fields.id',
            DB::raw('CONCAT(IFNULL(CONCAT(field_groups.name,": "),""),fields.name,"(Id:",fields.id,")") as name')
        );

        return $query->pluck('name', 'id');
    }

    /**
     * Show compare values based on selected form.
     *
     * @param int $formId
     * @param int $fieldId
     * @return Illuminate\Support\Collection
     */
    private function getCompareValues(int $companyId, int $unitTypeId): Collection
    {
        return Source::where('company_id', $companyId)
            ->where('unit_type_id', $unitTypeId)
            ->pluck('name', 'id');
    }
}
