<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Field;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class FieldTransformer extends TransformerAbstract
{

    /**
     * @param \App\Models\Field $field
     * @return array
     */
    public function transform(Field $field): array
    {
        // Set field name with field type
        $fieldName = $field->name . " <br /> " . "{" . $field->field_type_name . "}";

        // Get Reference Field name
        // if ($field->reference_value) {
        //     $referenceFieldValue = json_decode($field->reference_value);

        //     if (is_int($referenceFieldValue)) {
        //         $referenceFieldName = Field::where('id', $field->reference_value)
        //             ->pluck('name')
        //             ->first();
        //     } elseif (is_array($referenceFieldValue)) {
        //         // {
        //         //     "type" : "id",
        //         //     "value" : "1"
        //         // },
        //         // {
        //         //     "type" : "string",
        //         //     "value" : "*"
        //         // },
        //         // {
        //         //     "type" : "id",
        //         //     "value" : "12"
        //         // }
        //         foreach ($referenceFieldValue as $object) {
        //             $type = $object->type;
        //             $value = $object->value;
        //         }
        //     }
        // } else {
        //     $referenceFieldName = "";
        // }

        // Is Required
        if ($field->is_required === 1) {
            $isRequired = "True";
        } else {
            $isRequired = "False";
        }

        // Create edit link
        $editLink = Link::edit(route('forms.fields.edit', [$field->form_id, $field->id]));

        // Create delete link
        $deleteLink = Link::delete(
            route('forms.fields.destroy', [$field->form_id, $field->id]),
        );

        return [
            'id' => (int) $field->id,
            'field_group_name' => $field->field_group_name,
            'name' => (string) $fieldName,
            'length' => (int) $field->length,
            'sequence' => (int) $field->sequence,
            'reference_value' => $field->reference_value,
            'compare_value' => $field->source_name,
            'is_required' => Str::ucfirst($isRequired),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
